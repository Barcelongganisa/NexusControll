<!-- resources/views/screen_viewer.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Viewer - Watch Screen Broadcast</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        video {
            width: 100%;
            height: auto;
            border: 3px solid #10b981;
            border-radius: 8px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Screen Viewer</h1>
        <video id="screenVideo" autoplay playsinline controls muted style="width: 100%; max-height: 90vh; border: 1px solid #ccc;"></video>
    </div>

    <script>
        const video = document.getElementById('screenVideo');
        const socket = new WebSocket('ws://localhost:3000');
        let peer;

        socket.onopen = () => {
            console.log('WebSocket connection established');
            // Identify this client as a viewer
            socket.send(JSON.stringify({ role: 'viewer' }));
        };

        socket.onmessage = async (event) => {
            const message = event.data;
            let data;

            // Handle blob or string message
            if (message instanceof Blob) {
                try {
                    const text = await blobToText(message);
                    data = JSON.parse(text);
                } catch (e) {
                    console.error('Error reading blob or parsing JSON', e);
                    return;
                }
            } else {
                try {
                    data = JSON.parse(message);
                } catch (e) {
                    console.error('Received non-JSON message', message);
                    return;
                }
            }

            console.log('Received message from server: ', data);

            // Handle offer from broadcaster
            if (data.offer) {
                console.log('Received offer:', data.offer);

                peer = new RTCPeerConnection({
                    iceServers: [
                        { urls: 'stun:stun.l.google.com:19302' }
                    ]
                });

                // When track is received from broadcaster
                peer.ontrack = (e) => {
                    console.log('Track received:', e.streams[0]);
                    video.srcObject = e.streams[0];
                };

                // For debugging ICE state
                peer.oniceconnectionstatechange = () => {
                    console.log('ICE connection state:', peer.iceConnectionState);
                };

                await peer.setRemoteDescription(new RTCSessionDescription(data.offer));
                const answer = await peer.createAnswer();
                await peer.setLocalDescription(answer);

                console.log('Sending answer: ', answer);
                socket.send(JSON.stringify({ answer }));
            }

            // Handle ICE candidates from broadcaster
            if (data.iceCandidate && peer) {
                try {
                    console.log('Adding ICE candidate: ', data.iceCandidate);
                    await peer.addIceCandidate(data.iceCandidate);
                } catch (e) {
                    console.error('Error adding ICE candidate', e);
                }
            }
        };

        // Convert Blob to string
        async function blobToText(blob) {
            const reader = new FileReader();
            return new Promise((resolve, reject) => {
                reader.onload = () => resolve(reader.result);
                reader.onerror = (error) => reject(error);
                reader.readAsText(blob);
            });
        }
    </script>
</body>
</html>

