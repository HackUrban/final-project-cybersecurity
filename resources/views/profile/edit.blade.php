<x-layout>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                
                
                <form action="{{route('profile.update', Auth::user()->id)}}" method="PUT" class="card p-5 shadow">
                    @csrf
                    
                    
                    
                    {{-- EMAIL USER --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">EMAIL: <strong>{{Auth::user()->id->email}} </strong>. Vuoi modificarlo? <br>Inserisci qui il nuovo indirizzo email:</label>
                        <input type="email" class="form-control" id="email" aria-describedby="email">
                    </div>
                    
                    
                    {{-- PASSWORD USER --}}
                    <div class="mb-3">
                        <label for="description" class="form-label">Descrizione Prodotto</label>
                        <textarea name="description" class="form-control" placeholder="Scrivi qui..." id="description" style="height:100px"></textarea>
                    </div>
                    
                    {{-- CONFERMA INSERIMENTO--}}
                    <div class="mt-3 d-flex justify-content-center flex-column align-items-center">
                        <button type="submit" class="btn btn-success">Salva</button>
                        
                        {{-- ALTRO --}}
                        <a href="{{route('welcome')}}" class="text-secondary btn-primary mt-2">Torna alla Pagina principale</a>
                    </div>                    
                </form>                
            </div>
        </div>
    </div>
    
    
</x-layout>