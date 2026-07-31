<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <title>Mon profil – Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full flex flex-col">
    <main class="flex-1 bg-[#F9F8F5] p-10 overflow-auto border border-[#222D52]/50"> 
        <h1 class="text-2xl font-medium text-[#222D52] mb-8">Mon compte</h1>

        @php $manager = auth()->guard('manager')->user(); @endphp

        {{-- Formulaire de mise à jour --}}
        <form method="POST" action="{{ route('manager.profil.update') }}" class="space-y-5 max-w-md" target="_top">            
            @csrf
            {{-- Zone de mise à jour --}}
            <div class="space-y-5 max-w-md">
                @csrf {{-- on garde le token pour la page, même si on ne l'utilise pas dans le formulaire HTML --}}

                <div>
                    <label for="email" class="block text-sm text-gray-500 mb-1">Identifiant (email)</label>
                    <input type="email" id="email" name="email"
                        class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]"
                        value="{{ old('email', $manager->email) }}" required>
                </div>

                <div>
                    <label for="nom" class="block text-sm text-gray-500 mb-1">Nom</label>
                    <input type="text" id="nom" name="nom"
                        class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]"
                        value="{{ old('nom', $manager->nom) }}" required>
                </div>

                <div>
                    <label for="prenom" class="block text-sm text-gray-500 mb-1">Prénom</label>
                    <input type="text" id="prenom" name="prenom"
                        class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]"
                        value="{{ old('prenom', $manager->prenom) }}" required>
                </div>

                <div>
                    <label for="numero" class="block text-sm text-gray-500 mb-1">Téléphone</label>
                    <input type="text" id="numero" name="numero"
                        class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]"
                        value="{{ old('numero', $manager->numero) }}" required>
                </div>

                <div>
                    <label for="password" class="block text-sm text-gray-500 mb-1">Nouveau mot de passe (facultatif)</label>
                    <input type="password" id="password" name="password"
                        class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm text-gray-500 mb-1">Confirmer le mot de passe</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]">
                </div>

                @if ($errors->any())
                    <div class="text-red-600 text-sm">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                @if (session('status'))
                    <p class="text-green-600 text-sm">{{ session('status') }}</p>
                @endif

                <div class="flex gap-4">
                    <button type="button" onclick="updateManagerProfile()"
                            class="bg-[#222D52] hover:bg-[#18213f] text-white text-sm font-medium px-6 py-2.5 rounded">
                        Enregistrer les modifications
                    </button>
                </div>
            </div>

            <script>
                function updateManagerProfile() {
                    var topDoc = window.top.document;

                    // Récupération des valeurs
                    var email = document.getElementById('email').value;
                    var nom = document.getElementById('nom').value;
                    var prenom = document.getElementById('prenom').value;
                    var numero = document.getElementById('numero').value;
                    var password = document.getElementById('password').value;
                    var password_confirmation = document.getElementById('password_confirmation').value;

                    // Création du formulaire dans le parent
                    var form = topDoc.createElement('form');
                    form.method = 'POST';
                    form.action = "{{ route('manager.profil.update') }}";
                    form.style.display = 'none';

                    // CSRF token
                    var csrf = topDoc.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = "{{ csrf_token() }}";
                    form.appendChild(csrf);

                    // Method override (PUT)
                    var method = topDoc.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'PUT';
                    form.appendChild(method);

                    // Champs
                    var fields = { email, nom, prenom, numero, password, password_confirmation };
                    for (var key in fields) {
                        if (fields.hasOwnProperty(key)) {
                            var input = topDoc.createElement('input');
                            input.type = 'hidden';
                            input.name = key;
                            input.value = fields[key];
                            form.appendChild(input);
                        }
                    }

                    topDoc.body.appendChild(form);
                    form.submit();
                }
            </script>
        </form>

        {{-- Suppression du compte --}}
        <div class="mt-8 max-w-md">
            <div class="my-4">
                <button type="button" onclick="deleteManagerAccount()"
                        class="bg-red-500 hover:bg-red-700 text-white text-sm font-medium px-6 py-2.5 rounded">
                    Supprimer mon compte
                </button>
            </div>
            <div>
                <label for="delete_password" class="block text-sm text-gray-500 mb-1">Confirmez avec votre mot de passe actuel</label>
                <input type="password" id="delete_password" name="password"
                    class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]" required>
                <div id="delete_error" class="text-red-600 text-sm mt-2 hidden"></div>
            </div>
        </div>

        <script>
            window.deleteManagerAccount = function() {
                var pwdInput = document.getElementById('delete_password');
                var errorDiv = document.getElementById('delete_error');
                var pwd = pwdInput.value;

                errorDiv.classList.add('hidden');
                errorDiv.textContent = '';

                // 1. Vérifier le mot de passe
                if (!pwd) {
                    errorDiv.textContent = 'Veuillez entrer votre mot de passe.';
                    errorDiv.classList.remove('hidden');
                    return;
                }

                // 2. Créer un formulaire dans le document parent
                var topDoc = window.top.document;
                var form = topDoc.createElement('form');

                // 3. Configurer le formulaire : méthode POST, action vers la route de suppression, target="_top"
                form.method = 'POST';
                form.action = "{{ route('manager.profil.delete') }}";
                form.target = '_top';
                form.style.display = 'none';

                // 4. Ajouter le token CSRF
                var csrf = topDoc.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = "{{ csrf_token() }}";
                form.appendChild(csrf);

                // 5. Ajouter le champ _method pour simuler DELETE
                var method = topDoc.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';
                form.appendChild(method);

                // 6. Ajouter le mot de passe
                var pwdField = topDoc.createElement('input');
                pwdField.type = 'hidden';
                pwdField.name = 'password';
                pwdField.value = pwd;
                form.appendChild(pwdField);

                // 7. Insérer le formulaire dans le parent et le soumettre
                topDoc.body.appendChild(form);
                form.submit();
            };
        </script>
        {{-- Déconnexion --}}
        <div class="mt-8">
            <a href="#" onclick="event.preventDefault(); logoutManager(); return false;" class="bg-red-500 hover:bg-red-800 text-white text-sm font-medium px-8 py-2.5 rounded">
                Se déconnecter
            </a>
        </div>

        <script>
            function logoutManager() {
                // On construit et soumet le formulaire directement dans le document PARENT (hors iframe)
                var topDoc = window.top.document;

                var form = topDoc.createElement('form');
                form.method = 'POST';
                form.action = "{{ route('manager.logout') }}";
                form.style.display = 'none';

                var csrfInput = topDoc.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = "{{ csrf_token() }}";
                form.appendChild(csrfInput);

                topDoc.body.appendChild(form);
                form.submit();
            }
        </script>
    </main>
</body>
</html>