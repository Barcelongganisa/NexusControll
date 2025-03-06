const express = require("express");
const http = require("http");
const socketIo = require("socket.io");

const app = express();
const server = http.createServer(app);
const io = socketIo(server, {
    cors: { origin: "*" },
});

io.on("connection", (socket) => {
    console.log("Client connected:", socket.id);

    socket.on("screenData", (data) => {
        io.emit("updateScreen", `data:image/png;base64,${data}`); // Send image to clients
    });

    socket.on("disconnect", () => {
        console.log("Client disconnected:", socket.id);
    });
});

server.listen(3000, () => console.log("Server running on port 3000"));
