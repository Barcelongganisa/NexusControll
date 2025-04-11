// server.js (WebSocket server)
const WebSocket = require('ws');
const wss = new WebSocket.Server({ port: 3000 });

wss.on('connection', (ws) => {
    console.log('New client connected');

    ws.on('message', (message) => {
        const data = JSON.parse(message);

        // Relay offer
        if (data.offer) {
            console.log('Sending offer to viewers');
            wss.clients.forEach((client) => {
                if (client.readyState === WebSocket.OPEN) {
                    client.send(JSON.stringify({ offer: data.offer }));
                }
            });
        }

        // Relay answer
        if (data.answer) {
            console.log('Sending answer to broadcaster');
            wss.clients.forEach((client) => {
                if (client.readyState === WebSocket.OPEN) {
                    client.send(JSON.stringify({ answer: data.answer }));
                }
            });
        }



        
        // Relay ICE candidates
        if (data.iceCandidate) {
            console.log('Sending ICE candidate to all clients');
            wss.clients.forEach((client) => {
                if (client.readyState === WebSocket.OPEN) {
                    client.send(JSON.stringify({ iceCandidate: data.iceCandidate }));
                }
            });
        }
    });
});
