<a href="{{ $href }}" 
    target="popup" 
    class="{{ $class ?? '' }}"
>
    {{ $slot }}
</a>

@push('scripts')
<script type="text/javascript">
document.querySelectorAll('a[target="popup"]').forEach(function(element){
    element.addEventListener('click', function(e) {
        e.preventDefault();

        href = this.getAttribute('href');
        my_popup = window.open('{{ $href }}', 'popup', 'width=1000,height=800');
        window.addEventListener('message', function(e) {
            if(e.data == 'close') {
                window.location.reload();
            }
        });

        return false;
    });
});
</script>
@endpush