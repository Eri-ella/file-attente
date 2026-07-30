<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublie</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['public/js/admin.js'])

</head>
<body >

    @include('admin.entete')

    <main class="flex w-full">
        <div class="flex flex-col items-start justify-center w-1/2 min-h-screen bg-(--primary-color) gap-5 px-10">
            <p class="text-(--highlight-color) text-xs  tracking-widest  mb-4 ">BON RETOUR</p>
            <h2 class="text-(--white-color) text-xl md:text-4xl">Récupérez l'accès à votre compte en deux minutes.</h2>
        </div>
        <form class="flex flex-col items-start justify-center w-1/2 min-h-screen gap-2 text-(--primary-color) px-35" action="/admin/motdepasse">
            @csrf
            <p class="text-xs tracking-widest text-(--highlight-color) mb-5">ADMINISTRATION</p>
            <h3 class="text-2xl  text-(--primary-color) font-medium mb-2">Mot de passe oublié</h3>
            <p class="text-sm text-gray-600 mb-6">Récupérer votre mot de passe en moins de deux étapes</p>
            <div class="flex flex-col gap-3 w-full"> 
                <label class="text-[#222D52] font-medium ">Adresse e-mail</label>
                <input class="border-1 border-(--primary-color) p-2 rounded-lg bg-(--white-color) mail-input" type="text" name="" id="" placeholder="jeandev@gmail.com">                
            </div>
            <p class="text-xs place-self-end">Un code de réinitialisation sera envoyé à cette adresse.</p>
            <div class="flex flex-col w-full gap-5 mt-5 items-center justify-center">
                <input class="block mx-auto w-[280px] bg-[#222D52] hover:bg-[#18213f] text-white font-medium text-base py-3.5 mt-5 rounded-lg" type="submit" value="Recevoir le code">
                <a href="{{ route('connexionAdmin') }}">← Retour à la <b>connexion</b></a>
            </div>
        </form>
    </main>
    
</body>
</html>