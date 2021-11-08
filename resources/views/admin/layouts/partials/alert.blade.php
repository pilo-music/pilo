@if (session()->has('admin_message_text'))
    <div class="alert alert-{{ session()->get('admin_message_class') }}">
        {{ session()->get('admin_message_text') }}
    </div>
@endif
