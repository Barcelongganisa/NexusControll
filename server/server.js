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

// WebSocket Server for Commands (Using a Separate Port)
const wss = new WebSocket.Server({ port: 8080 });

wss.on("connection", (ws) => {
    console.log("✅ WebSocket client connected");
    
    // Associate PC metadata with this WebSocket connection
    let pcId = null;

    ws.on("message", (message) => {
        try {
            const data = JSON.parse(message);
            console.log("📩 Command received:", data);

            // If this is a registration message, save the PC info
            if (data.type === "register") {
                pcId = data.pc_id;
                
                // Add or update the PC in our connected PCs map
                connectedPCs.set(pcId, {
                    id: pcId,
                    name: data.pc_name || `PC ${pcId}`,
                    status: "Online",
                    lastSeen: new Date(),
                    imageUrl: "/images/pc.png"
                });
                
                // Notify all Socket.io clients about the new PC
                io.emit("pcConnected", connectedPCs.get(pcId));
                console.log(`🖥️ PC ${pcId} registered`);
                
                // Send confirmation back to the PC
                ws.send(JSON.stringify({ type: "registered", success: true }));
                
                return;
            }

            // For command messages, broadcast to target PC
            if (data.pc_id) {
                // Broadcast command to the specified client
                wss.clients.forEach((client) => {
                    if (client.pcId === data.pc_id && client.readyState === WebSocket.OPEN) {
                        client.send(JSON.stringify(data));
                    }
                });
            } else {
                // Broadcast command to ALL WebSocket clients except the sender
                wss.clients.forEach((client) => {
                    if (client !== ws && client.readyState === WebSocket.OPEN) {
                        client.send(JSON.stringify(data));
                    }
                });
            }

        } catch (error) {
            console.error("❌ Error processing WebSocket message:", error.message);
        }
    });

    ws.on("close", () => {
        console.log("🔌 WebSocket client disconnected");
        
        // If this was a registered PC, remove it from connected PCs
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

    // Send the currently connected PCs list
    socket.emit("initialConnectedPCs", Array.from(connectedPCs.values()));

    socket.on("screenData", (data) => {
        // Check if data includes PC ID
        let pcId = "unknown";
        let imageData = data;
        
        if (typeof data === "object" && data.pc_id) {
            pcId = data.pc_id;
            imageData = data.imageData;
            
            // Update lastSeen timestamp for this PC
            if (connectedPCs.has(pcId)) {
                connectedPCs.get(pcId).lastSeen = new Date();
            }
        }
        
        // Broadcast screen data with PC ID
        io.emit("updateScreen", {
            pcId: pcId,
            imageUrl: `data:image/png;base64,${imageData}`
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

// Health check endpoint to see connected PCs
app.get("/api/connected-pcs", (req, res) => {
    res.json(Array.from(connectedPCs.values()));
});

// Start a cleanup timer to remove stale PCs
setInterval(() => {
    const now = new Date();
    for (const [pcId, pc] of connectedPCs.entries()) {
        // Remove PCs that haven't been seen in 2 minutes
        if (now - pc.lastSeen > 2 * 60 * 1000) {
            connectedPCs.delete(pcId);
            io.emit("pcDisconnected", pcId);
            console.log(`⏱️ PC ${pcId} removed due to inactivity`);
        }
    }
}, 30000); // Run every 30 seconds

// Start the server
server.listen(3000, () => console.log("🚀 Server running on port 3000"));
console.log("🌐 WebSocket server running on ws://localhost:8080");