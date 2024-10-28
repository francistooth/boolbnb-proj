@extends('admin.index')

@section('user')
    @if (session('delete'))
        <div class="alert alert-danger mx-auto">
            {{ session('delete') }}
        </div>
    @endif

    <div class="container-fluid d-flex justify-content-between align-items-center mt-4 mb-4">
        <h3 class="text-secondary"> Messaggi per appartamento: <span class="fs-2 text-primary">{{ $apartment->title }}</span>
            </h2>
            <h6 class="text-muted">totale: {{ count($messages) }} messaggi</h6>
    </div>

    @if (!$messages || count($messages) === 0)
        <div class="alert alert-dark text-center mt-5">
            nessun messaggio ricevuto.
        </div>
    @else
        <div class="container-fluid overflow-auto">
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
                                    Messaggio ricevuto da {{ $message['received']->name }} <span class="text-muted">|</span>
                                    per:
                                    "{{ $message['apartment_name'] }}"
                                </div>

                                <div class="fw-light text-end me-2 w-25">
                                    il {{ date('d/m/Y \o\r\e H.i', strtotime($message['received']->created_at)) }}
                                </div>
                            </button>
                        </h2>
                        <div id="collapse-{{ $message['received']->id }}" class="accordion-collapse collapse"
                            aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                            <div class="accordion-body position-relative">
                                <div class="mb-2">
                                    Mittente: <strong>{{ $message['received']->email }}</strong>

                                </div>
                                <div>
                                    {{ $message['received']->message }}
                                </div>

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