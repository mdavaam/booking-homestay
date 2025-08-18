@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<script type="text/javascript">
    window.onload = function () {
        console.log('SnapToken:', '{{ $snapToken }}');
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                window.location.href = "/order-success/" + result.order_id;
            },
            onPending: function(result) {
                window.location.href = "/order/pending/" + result.order_id;
            },
            onError: function(result) {
                window.location.href = "/order/failed/" + result.order_id;
            },
            onClose: function() {
                window.location.href = "/home";
            }
        });
    };
</script>
