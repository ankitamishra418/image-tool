<style>
    .image-tool-page {
        min-height: calc(100vh - 150px);
        padding: 4rem 0;
        background: linear-gradient(135deg, #eef4ff, #fbf7ff);
    }

    .back-link {
        color: #5b45d8;
        font-size: .9rem;
        font-weight: 700;
        text-decoration: none;
    }

    .tool-panel {
        border: 0;
        border-radius: 1.4rem;
        box-shadow: 0 1.5rem 4rem rgba(51, 65, 120, .14);
    }

    .drop-zone {
        background: #fafbff;
        border: 2px dashed #bbc5e7;
        border-radius: 1rem;
        cursor: pointer;
        min-height: 240px;
        padding: 2rem;
    }

    .drop-zone:hover,
    .drop-zone.is-dragging {
        background: #f2efff;
        border-color: #6c4cff;
    }

    .upload-icon {
        align-items: center;
        background: #ebe7ff;
        border-radius: 50%;
        color: #6c4cff;
        display: inline-flex;
        height: 4rem;
        justify-content: center;
        width: 4rem;
    }

    .file-name {
        color: #172554;
        font-weight: 700;
    }

    .field-label {
        color: #39476f;
        font-size: .78rem;
        font-weight: 800;
    }

    .form-control,
    .form-select {
        border-color: #dde2f0;
        border-radius: .7rem;
        min-height: 3rem;
    }

    .tool-options {
        background: #f7f8fc;
        border: 1px solid #e9ebf4;
        border-radius: 1rem;
    }

    .tool-action {
        background: linear-gradient(135deg, #6c4cff, #4b39d9);
        border: 0;
        border-radius: .75rem;
        font-weight: 700;
        min-height: 3.25rem;
    }

    #result .result-card {
        border: 1px solid #e7e9f2;
        border-radius: 1rem;
        overflow: hidden;
    }

    #result img {
        background: #f7f8fc;
        max-height: 360px;
        object-fit: contain;
        width: 100%;
    }

    .crop-editor {
        background: #10172d;
        border-radius: 1rem;
        display: none;
        margin-top: 1.5rem;
        overflow: hidden;
        padding: 1rem;
    }

    .crop-editor.is-ready {
        display: block;
    }

    .crop-canvas {
        cursor: crosshair;
        display: inline-block;
        line-height: 0;
        max-width: 100%;
        overflow: hidden;
        position: relative;
        touch-action: none;
    }

    .crop-canvas img {
        height: auto;
        max-height: 460px;
        max-width: 100%;
        user-select: none;
        width: auto;
    }

    .crop-selection {
        background: linear-gradient(90deg, transparent 33.1%, rgba(255, 255, 255, .58) 33.4%, transparent 33.7%, transparent 66.3%, rgba(255, 255, 255, .58) 66.6%, transparent 66.9%), linear-gradient(transparent 33.1%, rgba(255, 255, 255, .58) 33.4%, transparent 33.7%, transparent 66.3%, rgba(255, 255, 255, .58) 66.6%, transparent 66.9%), rgba(108, 76, 255, .13);
        border: 2px solid #80a5ff;
        box-shadow: 0 0 0 9999px rgba(8, 12, 28, .53);
        box-sizing: border-box;
        cursor: move;
        display: none;
        position: absolute;
    }

    .crop-handle {
        background: #80a5ff;
        border: 1px solid #fff;
        border-radius: 50%;
        height: 10px;
        position: absolute;
        width: 10px;
    }

    .crop-handle[data-handle='nw'] {
        cursor: nwse-resize;
        left: -6px;
        top: -6px;
    }

    .crop-handle[data-handle='n'] {
        cursor: ns-resize;
        left: calc(50% - 5px);
        top: -6px;
    }

    .crop-handle[data-handle='ne'] {
        cursor: nesw-resize;
        right: -6px;
        top: -6px;
    }

    .crop-handle[data-handle='e'] {
        cursor: ew-resize;
        right: -6px;
        top: calc(50% - 5px);
    }

    .crop-handle[data-handle='se'] {
        bottom: -6px;
        cursor: nwse-resize;
        right: -6px;
    }

    .crop-handle[data-handle='s'] {
        bottom: -6px;
        cursor: ns-resize;
        left: calc(50% - 5px);
    }

    .crop-handle[data-handle='sw'] {
        bottom: -6px;
        cursor: nesw-resize;
        left: -6px;
    }

    .crop-handle[data-handle='w'] {
        cursor: ew-resize;
        left: -6px;
        top: calc(50% - 5px);
    }
</style>

<main class="image-tool-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-9">
                <a href="{{ route('home') }}" class="back-link d-inline-block mb-4">← All image tools</a>
                <section class="card tool-panel">
                    <div class="card-body p-4 p-md-5">
                        <div class="mb-4">
                            <p class="text-uppercase fw-bold small text-primary mb-2">XTeam image tools</p>
                            <h1 class="h2 fw-bold text-dark mb-2">{{ $title }}</h1>
                            <p class="text-secondary mb-0">{{ $description }}</p>
                        </div>
                        <input type="file" id="image" class="d-none" accept="image/jpeg,image/png,image/webp">
                        <div id="dropArea"
                            class="drop-zone text-center d-flex flex-column align-items-center justify-content-center"
                            role="button" tabindex="0" aria-label="Choose an image file or drag it here"><span
                                class="upload-icon mb-3" aria-hidden="true">↑</span><strong class="fs-5 text-dark">Drop
                                your image here</strong><span class="text-secondary mt-1">or <span
                                    class="text-primary fw-semibold">browse from your device</span></span><small
                                id="fileName" class="file-name mt-3 d-none"></small></div>

                        @if ($tool === 'crop')
                        <div id="cropEditor" class="crop-editor">
                            <p class="text-white small mb-2">Drag to create a crop. Drag inside to move it; use the dots
                                to resize.</p>
                            <div id="cropCanvas" class="crop-canvas">
                                <img id="cropPreview" alt="Crop preview">
                                <div id="cropSelection" class="crop-selection">
                                    <span class="crop-handle" data-handle="nw"></span>
                                    <span class="crop-handle" data-handle="n"></span>
                                    <span class="crop-handle"
                                        data-handle="ne"></span>
                                        <span class="crop-handle" data-handle="e"></span>
                                        <span
                                        class="crop-handle" data-handle="se"></span>
                                        <span class="crop-handle"
                                        data-handle="s"></span>
                                        <span class="crop-handle" data-handle="sw"></span>
                                        <span class="crop-handle" data-handle="w"></span>
                                </div>
                            </div>
                        </div>
                        @endif

                        <input type="hidden" id="quality" value="95">
                        <input type="hidden" id="width">
                        <input type="hidden" id="height"><input type="hidden" id="crop_width"><input type="hidden"
                            id="crop_height"><input type="hidden" id="crop_x" value="0"><input type="hidden" id="crop_y"
                            value="0"><input type="hidden" id="output_format" value="jpg"><input type="hidden"
                            id="remove_background" value="0">

                        @if ($tool === 'compressor')
                        <div class="row g-3 mt-1">
                            <div class="col-md-4"><label for="qualityInput" class="field-label mb-2">QUALITY
                                    (1–100)</label><input type="number" id="qualityInput" class="form-control"
                                    value="95" min="1" max="100"></div>
                            <div class="col-md-4"><label for="widthInput" class="field-label mb-2">WIDTH
                                    (OPTIONAL)</label><input type="number" id="widthInput" class="form-control" min="1"
                                    placeholder="Original"></div>
                            <div class="col-md-4"><label for="heightInput" class="field-label mb-2">HEIGHT
                                    (OPTIONAL)</label><input type="number" id="heightInput" class="form-control" min="1"
                                    placeholder="Original"></div>
                        </div>
                        @elseif ($tool === 'crop')
                        <div class="tool-options mt-4 p-3 p-md-4">
                            <p class="fw-bold text-dark mb-3">Crop area</p>
                            <div class="row g-3">
                                <div class="col-6 col-md-3"><label for="cropWidthInput"
                                        class="field-label mb-2">WIDTH</label><input type="number" id="cropWidthInput"
                                        class="form-control" min="1" placeholder="px"></div>
                                <div class="col-6 col-md-3"><label for="cropHeightInput"
                                        class="field-label mb-2">HEIGHT</label><input type="number" id="cropHeightInput"
                                        class="form-control" min="1" placeholder="px"></div>
                                <div class="col-6 col-md-3"><label for="cropXInput" class="field-label mb-2">X
                                        OFFSET</label><input type="number" id="cropXInput" class="form-control" min="0"
                                        value="0"></div>
                                <div class="col-6 col-md-3"><label for="cropYInput" class="field-label mb-2">Y
                                        OFFSET</label><input type="number" id="cropYInput" class="form-control" min="0"
                                        value="0"></div>
                            </div>
                        </div>
                        @elseif ($tool === 'converter')
                        <div class="tool-options mt-4 p-3 p-md-4"><label for="formatInput"
                                class="field-label mb-2">CONVERT TO</label><select id="formatInput" class="form-select">
                                <option value="jpg">JPG</option>
                                <option value="png">PNG</option>
                                <option value="webp">WEBP</option>
                            </select></div>
                        @else
                        <div class="alert alert-primary border-0 mt-4 mb-0"><strong>Flat background remover:</strong>
                            the color sampled from the top-left corner becomes transparent. Your output will be a PNG.
                        </div>
                        @endif

                        <button class="btn btn-primary tool-action w-100 mt-4" id="uploadBtn" type="button">{{
                            $buttonLabel }}</button>
                        <div class="progress mt-3 d-none" role="progressbar" aria-label="Upload progress"
                            aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" style="height:.65rem">
                            <div class="progress-bar bg-success" id="progressBar" style="width:0%">0%</div>
                        </div>
                        <div id="result" class="mt-4" aria-live="polite"></div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</main>

<script>
    const dropArea = document.getElementById('dropArea'); const fileInput = document.getElementById('image'); const fileName = document.getElementById('fileName');
    const inputValue = (selector) => $(selector).length ? $(selector).val() : '';
    const isCropTool = @json($tool === 'crop');
    const detectedFormat = () => ({ 'image/png': 'png', 'image/webp': 'webp' }[fileInput.files[0]?.type] || 'jpg');
    const syncOptions = () => { $('#quality').val(inputValue('#qualityInput') || 95); $('#width').val(inputValue('#widthInput')); $('#height').val(inputValue('#heightInput')); $('#crop_width').val(inputValue('#cropWidthInput')); $('#crop_height').val(inputValue('#cropHeightInput')); $('#crop_x').val(inputValue('#cropXInput') || 0); $('#crop_y').val(inputValue('#cropYInput') || 0); $('#output_format').val(inputValue('#formatInput') || (isCropTool || '{{ $tool }}' === 'compressor' ? detectedFormat() : '{{ $tool === 'background' ? 'png' : 'jpg' }}')); $('#remove_background').val('{{ $tool === 'background' ? '1' : '0' }}'); };
    const updateCropInputs = (selection) => { $('#cropWidthInput').val(selection.width); $('#cropHeightInput').val(selection.height); $('#cropXInput').val(selection.x); $('#cropYInput').val(selection.y); };
    const setupCropEditor = (file) => {
        if (!isCropTool) { return; }
        const preview = document.getElementById('cropPreview'); const editor = document.getElementById('cropEditor'); const canvas = document.getElementById('cropCanvas'); const selection = document.getElementById('cropSelection'); let interaction;
        const setSelection = (box) => { selection.style.display = 'block'; selection.style.left = `${box.left}px`; selection.style.top = `${box.top}px`; selection.style.width = `${box.width}px`; selection.style.height = `${box.height}px`; const scaleX = preview.naturalWidth / preview.clientWidth; const scaleY = preview.naturalHeight / preview.clientHeight; updateCropInputs({ x: Math.round(box.left * scaleX), y: Math.round(box.top * scaleY), width: Math.round(box.width * scaleX), height: Math.round(box.height * scaleY) }); };
        const point = (event) => { const bounds = canvas.getBoundingClientRect(); return { x: Math.max(0, Math.min(event.clientX - bounds.left, bounds.width)), y: Math.max(0, Math.min(event.clientY - bounds.top, bounds.height)) }; };
        const reader = new FileReader(); reader.onload = () => { preview.onload = () => { editor.classList.add('is-ready'); setSelection({ left: preview.clientWidth * .1, top: preview.clientHeight * .1, width: preview.clientWidth * .8, height: preview.clientHeight * .8 }); }; preview.src = reader.result; }; reader.readAsDataURL(file);
        canvas.onpointerdown = (event) => { const start = point(event); const handle = event.target.dataset.handle; const box = { left: selection.offsetLeft, top: selection.offsetTop, width: selection.offsetWidth, height: selection.offsetHeight }; interaction = { start, box, type: handle ? 'resize' : selection.contains(event.target) ? 'move' : 'draw', handle }; canvas.setPointerCapture(event.pointerId); };
        canvas.onpointermove = (event) => { if (!interaction) { return; } const end = point(event); const dx = end.x - interaction.start.x; const dy = end.y - interaction.start.y; const maxWidth = preview.clientWidth; const maxHeight = preview.clientHeight; let { left, top, width, height } = interaction.box;
            if (interaction.type === 'draw') { left = Math.min(interaction.start.x, end.x); top = Math.min(interaction.start.y, end.y); width = Math.abs(dx); height = Math.abs(dy); }
            if (interaction.type === 'move') { left = Math.max(0, Math.min(interaction.box.left + dx, maxWidth - width)); top = Math.max(0, Math.min(interaction.box.top + dy, maxHeight - height)); }
            if (interaction.type === 'resize') { let right = left + width; let bottom = top + height; if (interaction.handle.includes('w')) { left = Math.max(0, Math.min(interaction.box.left + dx, right - 20)); } if (interaction.handle.includes('e')) { right = Math.min(maxWidth, Math.max(interaction.box.left + 20, right + dx)); } if (interaction.handle.includes('n')) { top = Math.max(0, Math.min(interaction.box.top + dy, bottom - 20)); } if (interaction.handle.includes('s')) { bottom = Math.min(maxHeight, Math.max(interaction.box.top + 20, bottom + dy)); } width = right - left; height = bottom - top; }
            if (width >= 20 && height >= 20) { setSelection({ left, top, width, height }); }
        };
        canvas.onpointerup = () => { interaction = null; };
    };
    const showFile = (file) => { fileName.textContent = file.name; fileName.classList.remove('d-none'); setupCropEditor(file); };
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach((name) => dropArea.addEventListener(name, (event) => { event.preventDefault(); event.stopPropagation(); })); ['dragenter', 'dragover'].forEach((name) => dropArea.addEventListener(name, () => dropArea.classList.add('is-dragging'))); ['dragleave', 'drop'].forEach((name) => dropArea.addEventListener(name, () => dropArea.classList.remove('is-dragging')));
    dropArea.addEventListener('drop', (event) => { const [file] = event.dataTransfer.files; if (file) { fileInput.files = event.dataTransfer.files; showFile(file); } }); dropArea.addEventListener('click', () => fileInput.click()); dropArea.addEventListener('keydown', (event) => { if (event.key === 'Enter' || event.key === ' ') { event.preventDefault(); fileInput.click(); } }); fileInput.addEventListener('change', () => { if (fileInput.files[0]) { showFile(fileInput.files[0]); } });
    $('#uploadBtn').click(function () { const file = fileInput.files[0]; if (!file) { alert('Please select or drag an image first.'); return; } syncOptions(); const formData = new FormData(); ['image', 'quality', 'width', 'height', 'crop_width', 'crop_height', 'crop_x', 'crop_y', 'output_format', 'remove_background'].forEach((key) => formData.append(key, key === 'image' ? file : $(`#${key}`).val())); $('.progress').removeClass('d-none'); $('#result').empty(); $.ajax({ url: '{{ route('image.upload') }}', method: 'POST', headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }, data: formData, contentType: false, processData: false, xhr: function () { const xhr = new XMLHttpRequest(); xhr.upload.addEventListener('progress', (event) => { if (event.lengthComputable) { const percent = Math.round(event.loaded / event.total * 100); $('#progressBar').css('width', `${percent}%`).text(`${percent}%`); } }); return xhr; }, success: (res) => $('#result').html(`<div class="result-card card shadow-sm"><div class="row g-0 align-items-center"><div class="col-md-5"><img src="${res.preview}" alt="Processed image preview"></div><div class="col-md-7"><div class="card-body p-4"><p class="text-success fw-bold mb-2">✓ Your image is ready</p><div class="row row-cols-2 g-3 small text-secondary mb-4"><div><span class="d-block text-dark fw-semibold">Original</span>${res.original_size}</div><div><span class="d-block text-dark fw-semibold">Processed</span>${res.compressed_size}</div><div><span class="d-block text-dark fw-semibold">Format</span>${res.format}</div><div><span class="d-block text-dark fw-semibold">Dimensions</span>${res.width} × ${res.height}</div></div><a href="${res.download}" class="btn btn-success rounded-3 px-4 fw-semibold">Download image</a></div></div></div></div>`), error: (xhr) => { const message = xhr.responseJSON?.errors ? Object.values(xhr.responseJSON.errors).flat().join(' ') : 'We could not process this image. Please try another file.'; $('#result').html(`<div class="alert alert-danger mb-0">${message}</div>`); } }); });
</script>
