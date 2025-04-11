<!-- resources/views/screen_broadcast.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Screen Broadcast</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
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
<body class="bg-gray-100 p-6 text-gray-800">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Screen Broadcast (Main PC)</h1>
        <button id="startShare" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
            Start Sharing Screen
        </button>

        <video id="screen" autoplay muted playsinline></video>
    </div>

    <script>
        document.getElementById('startShare').addEventListener('click', async () => {
            try {
                const stream = await navigator.mediaDevices.getDisplayMedia({
                    video: { mediaSource: "screen" }
                });

                const video = document.getElementById('screen');
                video.srcObject = stream;

                const peer = new RTCPeerConnection({
                    iceServers: [
                        { urls: 'stun:stun.l.google.com:19302' }
                    ]
                });

                stream.getTracks().forEach(track => peer.addTrack(track, stream));

                const socket = new WebSocket('ws://localhost:3000');

                socket.onopen = async () => {
                    console.log('WebSocket connection established');

                    // Identify as broadcaster
                    socket.send(JSON.stringify({ role: 'broadcaster' }));

                    const offer = await peer.createOffer();
                    await peer.setLocalDescription(offer);
                    console.log('Sending offer: ', offer);
                    socket.send(JSON.stringify({ offer }));
                };

                peer.onicecandidate = (event) => {
                    if (event.candidate) {
                        console.log('Sending ICE candidate: ', event.candidate);
                        socket.send(JSON.stringify({ iceCandidate: event.candidate }));
                    }
                };

                // Handle incoming answer from viewer
                socket.onmessage = async (event) => {
                    let data;
                    try {
                        data = JSON.parse(event.data);
                    } catch (err) {
                        console.error('Invalid message from server:', event.data);
                        return;
                    }

                    if (data.answer) {
                        console.log('Received answer:', data.answer);
                        await peer.setRemoteDescription(new RTCSessionDescription(data.answer));
                    }

                    if (data.iceCandidate) {
                        try {
                            console.log('Received viewer ICE candidate:', data.iceCandidate);
                            await peer.addIceCandidate(data.iceCandidate);
                        } catch (e) {
                            console.error('Error adding viewer ICE candidate', e);
                        }
                    }
                };

            } catch (err) {
                alert("Error: " + err);
            }
        });
    </script>
</body>
</html>