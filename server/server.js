const express = require("express");
const http = require("http");
const socketIo = require("socket.io");
const WebSocket = require("ws");
const cors = require("cors");

const app = express();
app.use(cors());

const server = http.createServer(app);
const io = socketIo(server, {
    cors: { origin: "*" },
});

// Store connected PCs
const connectedPCs = new Map();

// WebSocket Server for Commands
const wss = new WebSocket.Server({ port: 8080 });

wss.on("connection", (ws) => {
    console.log("✅ WebSocket client connected");

    let pcId = null;

    ws.on("message", (message) => {
        try {
            const data = JSON.parse(message);
            console.log("📩 Command received:", data);

            if (data.type === "register") {
                pcId = data.pc_id;
                ws.pcId = pcId; // ✅ Attach pcId to the WebSocket connection

                connectedPCs.set(pcId, {
                    id: pcId,
                    name: data.pc_name || `PC ${pcId}`,
                    status: "Online",
                    lastSeen: new Date(),
                    imageUrl: "/images/pc.png"
                });

                io.emit("pcConnected", connectedPCs.get(pcId));
                console.log(`🖥️ PC ${pcId} registered`);

                ws.send(JSON.stringify({ type: "registered", success: true }));
                return;
            }

            if (data.pc_id) {
                let targetFound = false;
                wss.clients.forEach((client) => {
                    if (client.pcId === data.pc_id && client.readyState === WebSocket.OPEN) {
                        client.send(JSON.stringify(data));
                        targetFound = true;
                    }
                });

                if (!targetFound) {
                    console.warn(`⚠️ Target PC ${data.pc_id} not found`);
                }
            }
        } catch (error) {
            console.error("❌ Error processing WebSocket message:", error.message);
        }
    });

    ws.on("close", () => {
        console.log("🔌 WebSocket client disconnected");
        if (pcId) {
            connectedPCs.delete(pcId);
            io.emit("pcDisconnected", pcId);
            console.log(`🖥️ PC ${pcId} unregistered`);
        }
    });

    ws.on("error", (err) => console.error("⚠️ WebSocket error:", err.message));
});

// Socket.io Server for Screen Streaming
io.on("connection", (socket) => {
    console.log(`🖥️ Socket.io client connected: ${socket.id}`);

    socket.emit("initialConnectedPCs", Array.from(connectedPCs.values()));

    socket.on("screenData", (data) => {
        if (data.pc_id && connectedPCs.has(data.pc_id)) {
            connectedPCs.get(data.pc_id).lastSeen = new Date();
        }
        io.emit("updateScreen", {
            pcId: data.pc_id || "unknown",
            imageUrl: `data:image/png;base64,${data.imageData}`
        });
    });

    socket.on("updatePCStatus", (data) => {
        if (data.pc_id && connectedPCs.has(data.pc_id)) {
            const pc = connectedPCs.get(data.pc_id);
            pc.status = data.status;
            pc.lastSeen = new Date();
            io.emit("pcStatusUpdate", pc);
        }
    });

    socket.on("disconnect", () => {
        console.log(`❌ Socket.io client disconnected: ${socket.id}`);
    });

    socket.on("error", (err) => console.error("⚠️ Socket.io error:", err.message));
});

// Health check endpoint
app.get("/api/connected-pcs", (req, res) => {
    res.json(Array.from(connectedPCs.values()));
});

// Cleanup inactive PCs
setInterval(() => {
    const now = new Date();
    for (const [pcId, pc] of connectedPCs.entries()) {
        if (now - pc.lastSeen > 2 * 60 * 1000) {
            connectedPCs.delete(pcId);
            io.emit("pcDisconnected", pcId);
            console.log(`⏱️ PC ${pcId} removed due to inactivity`);
        }
    }
}, 30000);

server.listen(3000, () => console.log("🚀 Server running on port 3000"));
console.log("🌐 WebSocket server running on ws://localhost:8080");
