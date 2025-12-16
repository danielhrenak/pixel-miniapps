<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pridať položku</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 40px;
            max-width: 500px;
            width: 100%;
        }

        h1 {
            margin-bottom: 30px;
            color: #333;
            font-size: 28px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
            font-size: 14px;
        }

        input, textarea, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            transition: border-color 0.3s;
        }

        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        textarea {
            resize: vertical;
            min-height: 100px;
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        button:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        button:active {
            transform: translateY(0);
        }

        button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        .alert-warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .success-message {
            background: #d4edda;
            color: #155724;
            border: 2px solid #c3e6cb;
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            animation: slideDown 0.3s ease-out;
        }

        .success-message h2 {
            margin-bottom: 8px;
            font-size: 18px;
        }

        .success-message p {
            margin: 8px 0;
            font-size: 14px;
        }

        .success-actions {
            margin-top: 12px;
            display: flex;
            gap: 8px;
        }

        .success-actions a {
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .success-actions a.btn-primary {
            background: #155724;
            color: white;
        }

        .success-actions a.btn-primary:hover {
            background: #0d3620;
        }

        .success-actions a.btn-secondary {
            background: #e8f5e9;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .success-actions a.btn-secondary:hover {
            background: #c8e6c9;
        }

        .hidden-field {
            display: none;
        }

        .instruction {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 13px;
            line-height: 1.6;
            color: #555;
        }

        .instruction strong {
            color: #333;
            display: block;
            margin-bottom: 8px;
        }

        .instruction code {
            background: #fff;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            color: #667eea;
        }

        .preview-container {
            margin-bottom: 20px;
            padding: 12px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 2px solid #ddd;
        }

        .preview-container.loading {
            border-color: #667eea;
            background: #f0f3ff;
        }

        .preview-container.error {
            border-color: #dc3545;
            background: #fff5f5;
        }

        .preview-container.success {
            border-color: #28a745;
            background: #f0fdf4;
        }

        .preview-image {
            max-width: 100%;
            max-height: 300px;
            border-radius: 6px;
            display: block;
            margin: 0 auto;
        }

        .preview-video {
            width: 100%;
            height: 250px;
            border-radius: 6px;
        }

        .preview-status {
            font-size: 12px;
            margin-top: 8px;
            text-align: center;
            font-weight: 500;
        }

        .preview-status.loading {
            color: #667eea;
        }

        .preview-status.error {
            color: #dc3545;
        }

        .preview-status.success {
            color: #28a745;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Pridať položku</h1>

        <?php if ($this->Flash->render()): ?>
            <div class="success-message" id="success-alert">
                <h2>✓ Položka bola úspešne pridaná!</h2>
                <p>Vaša nová položka je teraz dostupná v TV aplikácii.</p>
                <div class="success-actions">
                    <a href="/tv-app-admin/index/1" class="btn-primary">Zobraziť všetky položky</a>
                    <a href="/tv-app-admin/add/1" class="btn-secondary">Pridať ďalšiu</a>
                </div>
            </div>
        <?php endif; ?>

        <?= $this->Form->create(null, ['method' => 'POST', 'id' => 'item-form']) ?>

        <!-- Type Selection -->
        <div class="form-group">
            <label for="type">Typ položky *</label>
            <?= $this->Form->select('type',
                [
                    '' => '-- Vyberte typ --',
                    'image' => 'Obrázok',
                    'video' => 'Video',
                    'text' => 'Text'
                ],
                ['id' => 'type', 'required' => true, 'data-target' => 'type-select']
            ) ?>
        </div>

        <!-- Video Instructions -->
        <div id="video-instruction" class="instruction hidden-field">
            <strong>📺 Ako skopírovat URL z YouTube:</strong>
            1. Otvorte video na YouTube<br>
            2. Kliknite na <code>Zdieľať</code> pod videom<br>
            3. Kliknite na <code>Kopírovat odkaz</code><br>
            4. Prilepte URL do poľa nižšie
        </div>

        <!-- Image Instructions -->
        <div id="image-instruction" class="instruction hidden-field">
            <strong>🖼️ Ako skopírovat URL obrázka:</strong>
            1. Kliknite pravým tlačítkom na obrázok<br>
            2. Vyberte <code>Kopírovat adresu obrázka</code><br>
            3. Prilepte URL do poľa nižšie
        </div>

        <!-- URL Field (for video/image) -->
        <div id="url-field" class="form-group hidden-field">
            <label for="url">URL *</label>
            <?= $this->Form->text('url', ['id' => 'url', 'placeholder' => 'https://example.com/image.jpg', 'data-field-type' => 'url']) ?>
        </div>

        <!-- Image Preview -->
        <div id="image-preview-container" class="preview-container hidden-field">
            <img id="image-preview" class="preview-image" alt="Náhľad obrázka">
            <div id="image-preview-status" class="preview-status"></div>
        </div>

        <!-- Video Preview -->
        <div id="video-preview-container" class="preview-container hidden-field">
            <iframe id="video-preview" class="preview-video" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <div id="video-preview-status" class="preview-status"></div>
        </div>

        <!-- Author Field -->
        <div class="form-group">
            <label for="author">Autor</label>
            <?= $this->Form->text('author', ['id' => 'author', 'placeholder' => 'Tvoje meno']) ?>
        </div>

        <!-- Description/Text Field (always visible) -->
        <div class="form-group">
            <label for="text">Text / Popis</label>
            <?= $this->Form->textarea('text', ['id' => 'text', 'placeholder' => 'Zadajte text, ktorý sa bude zobrazovať\n\nMôžete používať viacero riadkov']) ?>
        </div>

        <?= $this->Form->button('Pridať položku', ['type' => 'submit', 'id' => 'submit-btn']) ?>

        <?= $this->Form->end() ?>
    </div>

    <script>
        const typeSelect = document.getElementById('type');
        const urlField = document.getElementById('url-field');
        const urlInput = document.getElementById('url');
        const videoInstruction = document.getElementById('video-instruction');
        const imageInstruction = document.getElementById('image-instruction');
        const imagePreviewContainer = document.getElementById('image-preview-container');
        const imagePreview = document.getElementById('image-preview');
        const imagePreviewStatus = document.getElementById('image-preview-status');
        const videoPreviewContainer = document.getElementById('video-preview-container');
        const videoPreview = document.getElementById('video-preview');
        const videoPreviewStatus = document.getElementById('video-preview-status');
        const submitBtn = document.getElementById('submit-btn');
        const itemForm = document.getElementById('item-form');

        let previewValid = false;
        let currentPreviewType = null;

        function updateFormFields() {
            const selectedType = typeSelect.value;

            // Hide all conditional fields
            urlField.classList.add('hidden-field');
            videoInstruction.classList.add('hidden-field');
            imageInstruction.classList.add('hidden-field');
            imagePreviewContainer.classList.add('hidden-field');
            videoPreviewContainer.classList.add('hidden-field');

            previewValid = false;
            currentPreviewType = null;
            urlInput.value = '';
            updateSubmitButton();

            // Show relevant fields based on type
            if (selectedType === 'video') {
                urlField.classList.remove('hidden-field');
                videoInstruction.classList.remove('hidden-field');
                urlInput.required = true;
                urlInput.placeholder = 'https://www.youtube.com/watch?v=...';
                urlInput.name = 'video';
                currentPreviewType = 'video';
            } else if (selectedType === 'image') {
                urlField.classList.remove('hidden-field');
                imageInstruction.classList.remove('hidden-field');
                urlInput.required = true;
                urlInput.placeholder = 'https://example.com/image.jpg';
                urlInput.name = 'image';
                currentPreviewType = 'image';
            } else if (selectedType === 'text') {
                urlInput.required = false;
                urlInput.name = 'url';
                previewValid = true;
                updateSubmitButton();
            }
        }

        function updateSubmitButton() {
            if (currentPreviewType === null) {
                submitBtn.disabled = false;
            } else {
                submitBtn.disabled = !previewValid;
            }
        }

        function loadImagePreview(url) {
            imagePreviewContainer.classList.remove('hidden-field');
            imagePreviewContainer.classList.add('loading');
            imagePreviewStatus.textContent = 'Načítavam náhľad...';
            imagePreviewStatus.className = 'preview-status loading';
            previewValid = false;
            updateSubmitButton();

            const img = new Image();
            img.onload = () => {
                imagePreview.src = url;
                imagePreviewContainer.classList.remove('loading');
                imagePreviewContainer.classList.add('success');
                imagePreviewStatus.textContent = '✓ Náhľad sa úspešne načítal';
                imagePreviewStatus.className = 'preview-status success';
                previewValid = true;
                updateSubmitButton();
            };
            img.onerror = () => {
                imagePreviewContainer.classList.remove('loading');
                imagePreviewContainer.classList.add('error');
                imagePreviewStatus.textContent = '✗ Nepodarilo sa načítať obrázok. Skontrolujte URL.';
                imagePreviewStatus.className = 'preview-status error';
                previewValid = false;
                updateSubmitButton();
            };
            img.src = url;
        }

        function loadVideoPreview(url) {
            videoPreviewContainer.classList.remove('hidden-field');
            videoPreviewContainer.classList.add('loading');
            videoPreviewStatus.textContent = 'Načítavam náhľad...';
            videoPreviewStatus.className = 'preview-status loading';
            previewValid = false;
            updateSubmitButton();

            // Extract YouTube video ID from various URL formats
            let videoId = null;
            const youtubeRegex = /(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([^&\n?#]+)/;
            const match = url.match(youtubeRegex);

            if (match && match[1]) {
                videoId = match[1];
            }

            if (!videoId) {
                videoPreviewContainer.classList.remove('loading');
                videoPreviewContainer.classList.add('error');
                videoPreviewStatus.textContent = '✗ Neplatný YouTube URL. Skontrolujte URL.';
                videoPreviewStatus.className = 'preview-status error';
                previewValid = false;
                updateSubmitButton();
                return;
            }

            const embedUrl = `https://www.youtube.com/embed/${videoId}`;
            videoPreview.src = embedUrl;

            // Test if video loads successfully
            const testImg = new Image();
            testImg.onload = () => {
                videoPreviewContainer.classList.remove('loading');
                videoPreviewContainer.classList.add('success');
                videoPreviewStatus.textContent = '✓ Video sa úspešne načítalo';
                videoPreviewStatus.className = 'preview-status success';
                previewValid = true;
                updateSubmitButton();
            };
            testImg.onerror = () => {
                videoPreviewContainer.classList.remove('loading');
                videoPreviewContainer.classList.add('error');
                videoPreviewStatus.textContent = '✗ Toto video sa nepodarilo načítať. Skontrolujte URL.';
                videoPreviewStatus.className = 'preview-status error';
                previewValid = false;
                updateSubmitButton();
            };
            testImg.src = `https://img.youtube.com/vi/${videoId}/default.jpg`;
        }

        urlInput.addEventListener('input', (e) => {
            const url = e.target.value.trim();

            if (!url) {
                imagePreviewContainer.classList.add('hidden-field');
                videoPreviewContainer.classList.add('hidden-field');
                previewValid = false;
                updateSubmitButton();
                return;
            }

            if (currentPreviewType === 'image') {
                loadImagePreview(url);
            } else if (currentPreviewType === 'video') {
                loadVideoPreview(url);
            }
        });

        itemForm.addEventListener('submit', (e) => {
            if (currentPreviewType !== null && !previewValid) {
                e.preventDefault();
                alert('Náhľad sa nepodarilo načítať. Skontrolujte URL a skúste znova.');
            }
        });

        typeSelect.addEventListener('change', updateFormFields);

        // Initialize on page load
        updateFormFields();

        // Auto-hide success message after 5 seconds and reset form
        const successAlert = document.getElementById('success-alert');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.animation = 'slideDown 0.3s ease-out reverse';
                setTimeout(() => {
                    successAlert.style.display = 'none';
                    // Reset form
                    itemForm.reset();
                    updateFormFields();
                }, 300);
            }, 5000);
        }
    </script>
</body>
</html>
