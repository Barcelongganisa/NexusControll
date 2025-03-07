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

// WebSocket Server for Commands (Using a Separate Port)
const wss = new WebSocket.Server({ port: 8080 });

wss.on("connection", (ws) => {
    console.log("✅ WebSocket client connected");

    ws.on("message", (message) => {
        try {
            const data = JSON.parse(message);
            console.log("📩 Command received:", data);

            // Broadcast command to ALL WebSocket clients except the sender
            wss.clients.forEach((client) => {
                if (client !== ws && client.readyState === WebSocket.OPEN) {
                    client.send(JSON.stringify(data));
                }
            });

        } catch (error) {
            console.error("❌ Error processing WebSocket message:", error.message);
        }
    });

    ws.on("close", () => console.log("🔌 WebSocket client disconnected"));

    ws.on("error", (err) => console.error("⚠️ WebSocket error:", err.message));
});

// Socket.io Server for Screen Streaming
io.on("connection", (socket) => {
    console.log(`🖥️ Socket.io client connected: ${socket.id}`);

    socket.on("screenData", (data) => {
        io.emit("updateScreen", `data:image/png;base64,${data}`); // Broadcast screen data
    });

    socket.on("disconnect", () => {
        console.log(`❌ Socket.io client disconnected: ${socket.id}`);
    });

    socket.on("error", (err) => console.error("⚠️ Socket.io error:", err.message));
});

// Start the server
server.listen(3000, () => console.log("🚀 Server running on port 3000"));
console.log("🌐 WebSocket server running on ws://localhost:8080");
