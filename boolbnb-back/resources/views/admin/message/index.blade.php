@extends('admin.index')

@section('user')
    @if (session('delete'))
        <div class="alert alert-danger mx-auto">
            {{ session('delete') }}
        </div>
    @endif

    <div class="container-fluid">
        <a href="{{ route('admin.apartments.index') }}" class="btn btn-primary">
            <i class="fa-solid fa-arrow-left"></i>
        </a>

        <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
            <h3> Messaggi ricevuti:</h3>
            <h6 class="text-muted text-end">totale:
                {{ count($messages) > 1 ? count($messages) . ' messaggi' : count($messages) . ' messaggio' }} </h6>
        </div>
    </div>

    @if (!$messages || count($messages) === 0)
        <div class="container">
            <div class="alert alert-dark text-center mt-5">
                nessun messaggio ricevuto.
            </div>
        </div>
    @else
        <div class="container overflow-auto">
            @foreach ($messages as $message)
                <!-- modale -->
                <div class="modal fade" id="deleteModal-{{ $message['received']->id }}" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 1000">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Conferma
                                    Eliminazione</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Sei sicuro di voler eliminare il messaggio di "{{ $message['received']->email }}"?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>

                                <!-- form eliminazione -->
                                <form action="{{ route('admin.message.destroy', $message['received']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Conferma</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse-{{ $message['received']->id }}" aria-expanded="false"
                                aria-controls="collapseOne">
                                <div class="w-75">
                                    <span class="d-none d-md-inline">Messaggio ricevuto</span>
                                    da
                                    {{ $message['received']->name }}
                                    <span class="text-muted d-none d-md-inline">|</span>
                                    <br class="d-inline d-md-none">
                                    per:
                                    "{{ $message['apartment_name'] }}"
                                </div>

                                <div class="fw-light text-end me-2 w-25">
                                    <span class="fw-light d-none d-md-inline">il</span>
                                    {{ date('d/m/Y \o\r\e H.i', strtotime($message['received']->created_at)) }}
                                </div>
                            </button>
                        </h2>
                        <div id="collapse-{{ $message['received']->id }}" class="accordion-collapse collapse"
                            aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                            <div class="accordion-body position-relative" style="word-break: break-word;">
                                Mittente: <strong>{{ $message['received']->email }}</strong>
                                <br>
                                {{ $message['received']->message }}

                                {{-- <button type="button" class="btn btn-danger position-absolute"
                                    style="top: 15px; right: 15px" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal-{{ $message['received']->id }}">
                                    <i class="fa-solid fa-trash text-light"></i>
                                </button> --}}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </tbody>
            </table>


        </div>
    @endif

@endsection
