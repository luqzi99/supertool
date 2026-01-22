<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Converter - Supertool</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script> <!-- Fallback/Quick dev if local build fails, but mostly for preview assurance -->
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ url('/') }}" class="text-2xl font-bold text-indigo-600 hover:text-indigo-700 transition">Supertool</a>
            <nav>
                <a href="{{ route('tools.index') }}" class="text-gray-600 hover:text-indigo-600 font-medium transition">Back to Tools</a>
            </nav>
        </div>
    </header>

    <main class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Image Converter</h1>
            <p class="text-lg text-gray-600">Convert, resize, and optimize your images instantly. Secure and private.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="p-8">
                <form id="converterForm" class="space-y-8">
                    @csrf
                    
                    <!-- File Upload Section -->
                    <div class="space-y-4">
                        <label class="block text-sm font-medium text-gray-700">Upload Image</label>
                        <div id="dropZone" class="relative group border-2 border-dashed border-gray-300 rounded-xl p-8 transition-all duration-200 ease-in-out hover:border-indigo-500 hover:bg-indigo-50 cursor-pointer">
                            <input type="file" name="image" id="imageInput" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/jpeg,image/png,image/webp,image/gif" required>
                            
                            <div id="uploadPlaceholder" class="text-center pointer-events-none">
                                <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-indigo-500 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="mt-2 text-sm text-gray-600">Drag and drop or click to upload</p>
                                <p class="text-xs text-gray-500 mt-1">PNG, JPG, WEBP, GIF up to 10MB</p>
                            </div>

                            <div id="filePreviewContainer" class="hidden flex flex-col items-center">
                                <img id="filePreview" class="max-h-64 rounded-lg shadow-sm object-contain mb-4" src="" alt="Preview">
                                <p id="fileName" class="text-sm font-medium text-gray-900"></p>
                                <p id="fileSize" class="text-xs text-gray-500"></p>
                                <button type="button" id="removeFile" class="mt-2 text-sm text-red-500 hover:text-red-700 font-medium">Remove</button>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Format Selection -->
                        <div class="space-y-4">
                            <label class="block text-sm font-medium text-gray-700">Target Format</label>
                            <div class="grid grid-cols-2 gap-3">
                                @foreach(['jpeg' => 'JPG', 'png' => 'PNG', 'webp' => 'WEBP', 'gif' => 'GIF'] as $val => $label)
                                <label class="relative flex items-center justify-center p-3 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50 focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500 has-[:checked]:bg-indigo-50 has-[:checked]:border-indigo-500 has-[:checked]:text-indigo-700 transition">
                                    <input type="radio" name="format" value="{{ $val }}" class="sr-only" {{ $val === 'jpeg' ? 'checked' : '' }}>
                                    <span class="font-medium text-sm">{{ $label }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Settings -->
                        <div class="space-y-4">
                            <div id="qualityControl" class="space-y-2">
                                <div class="flex justify-between">
                                    <label for="quality" class="block text-sm font-medium text-gray-700">Quality</label>
                                    <span id="qualityValue" class="text-sm text-gray-500">90%</span>
                                </div>
                                <input type="range" name="quality" id="quality" min="1" max="100" value="90" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="width" class="block text-sm font-medium text-gray-700">Width (px)</label>
                                    <input type="number" name="width" id="width" placeholder="Auto" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border">
                                </div>
                                <div>
                                    <label for="height" class="block text-sm font-medium text-gray-700">Height (px)</label>
                                    <input type="number" name="height" id="height" placeholder="Auto" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="pt-4">
                        <button type="submit" id="convertBtn" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                            <span id="btnText">Convert Image</span>
                            <svg id="loadingIcon" class="hidden animate-spin ml-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </div>
                </form>

                <!-- Error Message -->
                <div id="errorMessage" class="hidden mt-6 p-4 rounded-md bg-red-50 border border-red-200">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Conversion Failed</h3>
                            <div class="mt-2 text-sm text-red-700" id="errorText"></div>
                        </div>
                    </div>
                </div>

                <!-- Result Section -->
                <div id="resultSection" class="hidden mt-8 pt-8 border-t border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Conversion Complete!</h3>
                    
                     <div class="flex flex-col md:flex-row gap-8 items-start">
                        <!-- Result Preview -->
                        <div class="w-full md:w-1/2 bg-gray-50 rounded-lg p-4 flex items-center justify-center border border-gray-200">
                             <img id="resultPreview" src="" alt="Result" class="max-h-64 object-contain rounded shadow-sm">
                        </div>

                        <!-- Download Actions -->
                        <div class="w-full md:w-1/2 space-y-4">
                            <div class="bg-indigo-50 rounded-lg p-4 border border-indigo-100">
                                <p class="text-sm text-indigo-800 font-medium mb-1">Your file is ready</p>
                                <p class="text-xs text-indigo-600" id="resultMeta"></p>
                            </div>
                            
                            <a id="downloadLink" href="#" class="w-full flex items-center justify-center px-4 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 transition">
                                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Download Image
                            </a>
                            
                            <button onclick="location.reload()" class="w-full flex items-center justify-center px-4 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition">
                                Convert Another
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('converterForm');
            const dropZone = document.getElementById('dropZone');
            const imageInput = document.getElementById('imageInput');
            const uploadPlaceholder = document.getElementById('uploadPlaceholder');
            const filePreviewContainer = document.getElementById('filePreviewContainer');
            const filePreview = document.getElementById('filePreview');
            const fileName = document.getElementById('fileName');
            const fileSize = document.getElementById('fileSize');
            const qualityControl = document.getElementById('qualityControl');
            const qualityInput = document.getElementById('quality');
            const qualityValue = document.getElementById('qualityValue');
            const formatInputs = document.querySelectorAll('input[name="format"]');
            const convertBtn = document.getElementById('convertBtn');
            const btnText = document.getElementById('btnText');
            const loadingIcon = document.getElementById('loadingIcon');
            const errorMessage = document.getElementById('errorMessage');
            const errorText = document.getElementById('errorText');
            const resultSection = document.getElementById('resultSection');
            const resultPreview = document.getElementById('resultPreview');
            const downloadLink = document.getElementById('downloadLink');
            const resultMeta = document.getElementById('resultMeta');
            const removeFileBtn = document.getElementById('removeFile');

            // Quality slider update
            qualityInput.addEventListener('input', (e) => qualityValue.textContent = e.target.value + '%');

            // Toggle quality visibility based on format
            function updateQualityVisibility() {
                const format = document.querySelector('input[name="format"]:checked').value;
                if (['jpeg', 'webp'].includes(format)) {
                    qualityControl.classList.remove('opacity-50', 'pointer-events-none');
                } else {
                    qualityControl.classList.add('opacity-50', 'pointer-events-none');
                }
            }
            formatInputs.forEach(input => input.addEventListener('change', updateQualityVisibility));
            updateQualityVisibility();

            // File Handling
            function handleFile(file) {
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        filePreview.src = e.target.result;
                        filePreviewContainer.classList.remove('hidden');
                        uploadPlaceholder.classList.add('hidden');
                        fileName.textContent = file.name;
                        fileSize.textContent = (file.size / 1024 / 1024).toFixed(2) + ' MB';
                    }
                    reader.readAsDataURL(file);
                }
            }

            imageInput.addEventListener('change', (e) => handleFile(e.target.files[0]));

            // Drag and Drop Effects
            dropZone.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropZone.classList.add('border-indigo-500', 'bg-indigo-50');
            });
            ['dragleave', 'drop'].forEach(evt => {
                dropZone.addEventListener(evt, (e) => {
                    dropZone.classList.remove('border-indigo-500', 'bg-indigo-50');
                });
            });
            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                const files = e.dataTransfer.files;
                if (files.length) {
                    imageInput.files = files;
                    handleFile(files[0]);
                }
            });
            
            removeFileBtn.addEventListener('click', (e) => {
                e.stopPropagation(); // prevent triggering dropZone click
                imageInput.value = '';
                filePreview.src = '';
                filePreviewContainer.classList.add('hidden');
                uploadPlaceholder.classList.remove('hidden');
            });

            // Form Submission
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                
                if (!imageInput.files.length) return;

                // UI Loading State
                convertBtn.disabled = true;
                btnText.textContent = 'Processing...';
                loadingIcon.classList.remove('hidden');
                errorMessage.classList.add('hidden');
                resultSection.classList.add('hidden');

                const formData = new FormData(form);

                try {
                    const response = await fetch('{{ route("tools.image-converter.convert") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    if (!response.ok) {
                        const err = await response.json();
                        throw new Error(err.message || 'Conversion failed');
                    }

                    const blob = await response.blob();
                    const url = window.URL.createObjectURL(blob);
                    const format = document.querySelector('input[name="format"]:checked').value;
                    
                    // Show Result
                    resultPreview.src = url;
                    downloadLink.href = url;
                    downloadLink.download = `converted_image.${format === 'jpeg' ? 'jpg' : format}`;
                    resultMeta.textContent = `${(blob.size / 1024).toFixed(2)} KB • ${format.toUpperCase()}`;
                    
                    resultSection.classList.remove('hidden');
                    
                    // Scroll to result
                    resultSection.scrollIntoView({ behavior: 'smooth' });

                } catch (error) {
                    console.error(error);
                    errorMessage.classList.remove('hidden');
                    errorText.textContent = 'An error occurred during conversion. Please try again or check your file.';
                } finally {
                    convertBtn.disabled = false;
                    btnText.textContent = 'Convert Image';
                    loadingIcon.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>
