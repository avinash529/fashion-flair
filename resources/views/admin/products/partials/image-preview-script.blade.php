@push('scripts')
<script>
const uploadArea = document.getElementById('uploadArea');
const imageInput = document.getElementById('imageInput');
const imagePreview = document.getElementById('imagePreview');

if (uploadArea && imageInput && imagePreview) {
    uploadArea.addEventListener('dragover', (event) => {
        event.preventDefault();
        uploadArea.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', (event) => {
        event.preventDefault();
        uploadArea.classList.remove('dragover');

        if (event.dataTransfer.files.length > 0) {
            imageInput.files = event.dataTransfer.files;
            previewImage(event.dataTransfer.files[0]);
        }
    });

    imageInput.addEventListener('change', (event) => {
        if (event.target.files.length > 0) {
            previewImage(event.target.files[0]);
        }
    });
}

function previewImage(file) {
    const reader = new FileReader();
    reader.onload = (event) => {
        imagePreview.src = event.target.result;
        imagePreview.classList.remove('hidden');
        uploadArea.querySelector('span')?.classList.add('hidden');
    };
    reader.readAsDataURL(file);
}
</script>
@endpush
