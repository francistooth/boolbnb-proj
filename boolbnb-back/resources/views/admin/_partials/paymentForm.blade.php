<div class="modal fade" id="sponsorModal-{{ $sponsor->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true" style="z-index: 1000">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Conferma
                    Pagamento</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Acquisto sponsor "{{ $sponsor->title }}" per un totale di €
                {{ $sponsor->price }}

            </div>
            <div class="modal-footer justify-content-center">

                <!-- form pagamento con identificatore unico -->
                <form id="payment-form-{{ $sponsor->id }}" action="{{ route('admin.payment.store', $apartment->id) }}"
                    method="POST" class="text-center">
                    @csrf

                    <div id="dropin-container-{{ $sponsor->id }}"></div>

                    <!-- campi nascosti per passare id dello sponsor -->
                    <input type="hidden" name="sponsor_id" value="{{ $sponsor->id }}">
                    <input type="hidden" name="apartment_id" value="{{ $apartment->id }}">
                    <input type="hidden" name="amount" value="{{ $sponsor->price }}">

                    <button type="submit" class="btn btn-success text-white">Acquista</button>

                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annulla</button>

                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ho+j7jyWK8fNQe+A12Wg4A6lB1J6LOuYxgAs5f0bb5RmXsO1Huxy5Dke++dJzD5y" crossorigin="anonymous">
</script>


<script src="https://js.braintreegateway.com/web/dropin/1.33.7/js/dropin.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var client_token = "{{ $clientToken }}";

        // Itera su ogni sponsor per gestire le modali
        @foreach ($sponsors as $sponsor)
            var modal = document.getElementById('sponsorModal-{{ $sponsor->id }}');
            modal.addEventListener('show.bs.modal', function() {
                var form = document.querySelector('#payment-form-{{ $sponsor->id }}');
                var container = document.querySelector('#dropin-container-{{ $sponsor->id }}');

                // Inizializza Braintree dropin quando la modale si apre
                braintree.dropin.create({
                    authorization: client_token,
                    selector: container
                }, function(err, instance) {
                    if (err) {
                        console.error(err);
                        return;
                    }
                    form.addEventListener('submit', function(event) {
                        event.preventDefault();
                        instance.requestPaymentMethod(function(err, payload) {
                            if (err) {
                                console.error(err);
                                return;
                            }
                            // Aggiungi il nonce al form e invia
                            var nonceInput = document.createElement('input');
                            nonceInput.setAttribute('type', 'hidden');
                            nonceInput.setAttribute('name',
                                'payment_method_nonce');
                            nonceInput.setAttribute('value', payload.nonce);
                            form.appendChild(nonceInput);
                            form.submit();
                        });
                    });
                });
            });
        @endforeach
    });
</script>
