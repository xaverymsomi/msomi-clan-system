<div x-data="voiceRecorder({{ $tradition->id }})" class="bg-purple-50 rounded-lg p-6 border-2 border-dashed border-purple-200">
    <div class="flex items-center justify-between mb-4">
        <h4 class="font-bold text-purple-900">{{ __('traditions.record_oral_history') ?? 'Record Oral History' }}</h4>
        <div class="flex items-center space-x-2">
            <span x-show="isRecording" class="flex h-3 w-3 relative">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
            </span>
            <span x-text="formatTime(timer)" class="font-mono text-gray-700">00:00</span>
        </div>
    </div>

    <div class="flex flex-col items-center space-y-4">
        <!-- Control Buttons -->
        <div class="flex space-x-4">
            <button @click="startRecording" x-show="!isRecording && !audioBlob" class="bg-red-600 text-white p-4 rounded-full hover:bg-red-700 transition shadow-lg">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7 4a3 3 0 016 0v4a3 3 0 11-6 0V4zm4 10.93A7.001 7.001 0 0017 8a1 1 0 10-2 0A5 5 0 115 8a1 1 0 00-2 0 7.001 7.001 0 006 6.93V17H6a1 1 0 100 2h8a1 1 0 100-2h-3v-2.07z" clip-rule="evenodd" />
                </svg>
            </button>

            <button @click="stopRecording" x-show="isRecording" class="bg-gray-800 text-white p-4 rounded-full hover:bg-gray-900 transition shadow-lg anim-pulse">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                    <rect x="6" y="6" width="12" height="12" rx="2" ry="2"></rect>
                </svg>
            </button>

            <button @click="resetRecorder" x-show="audioBlob" class="bg-gray-200 text-gray-700 p-4 rounded-full hover:bg-gray-300 transition">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        </div>

        <!-- Preview & Upload -->
        <div x-show="audioUrl" class="w-full space-y-4">
            <audio :src="audioUrl" controls class="w-full"></audio>
            <button @click="uploadRecording" :disabled="isUploading" class="w-full bg-purple-600 text-white py-3 rounded-lg font-bold hover:bg-purple-700 disabled:opacity-50 transition flex items-center justify-center">
                <template x-if="!isUploading">
                    <span>{{ __('traditions.save_to_archive') ?? 'Save to Archive' }}</span>
                </template>
                <template x-if="isUploading">
                    <span class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Archiving...
                    </span>
                </template>
            </button>
        </div>
    </div>
</div>

<script>
function voiceRecorder(traditionId) {
    return {
        isRecording: false,
        isUploading: false,
        mediaRecorder: null,
        audioChunks: [],
        audioBlob: null,
        audioUrl: null,
        timer: 0,
        interval: null,

        startRecording() {
            navigator.mediaDevices.getUserMedia({ audio: true })
                .then(stream => {
                    this.mediaRecorder = new MediaRecorder(stream);
                    this.audioChunks = [];
                    this.mediaRecorder.ondataavailable = (event) => {
                        this.audioChunks.push(event.data);
                    };
                    this.mediaRecorder.onstop = () => {
                        this.audioBlob = new Blob(this.audioChunks, { type: 'audio/webm' });
                        this.audioUrl = URL.createObjectURL(this.audioBlob);
                        stream.getTracks().forEach(track => track.stop());
                    };
                    this.mediaRecorder.start();
                    this.isRecording = true;
                    this.timer = 0;
                    this.interval = setInterval(() => { this.timer++ }, 1000);
                });
        },

        stopRecording() {
            this.mediaRecorder.stop();
            this.isRecording = false;
            clearInterval(this.interval);
        },

        resetRecorder() {
            this.audioBlob = null;
            this.audioUrl = null;
            this.timer = 0;
        },

        uploadRecording() {
            this.isUploading = true;
            const formData = new FormData();
            formData.append('audio', this.audioBlob, 'recording.webm');
            formData.append('duration', this.timer);

            fetch(`/traditions/${traditionId}/voice-memo`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    window.location.reload();
                } else {
                    alert('Upload failed: ' + data.message);
                    this.isUploading = false;
                }
            })
            .catch(err => {
                console.error(err);
                this.isUploading = false;
            });
        },

        formatTime(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = seconds % 60;
            return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
        }
    }
}
</script>
