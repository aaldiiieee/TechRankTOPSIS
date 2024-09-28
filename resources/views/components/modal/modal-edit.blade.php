<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $id }}Label">{{ $title }}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="{{ $formId }}" action="{{ $action }}" method="POST">
                    @csrf
                    {{ $slot }}
                    <button type="submit" class="btn btn-primary w-100">{{ $submitLabel }}</button>
                </form>
            </div>
        </div>
    </div>
</div>