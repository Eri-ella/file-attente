<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceuil</title>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <script type="module" src="/src/main.js"></script>
</head>
<body>
    <header class="flex items-center justify-between bg-(--white-color) border-b-1 border-(--primary-color) w-full px-10">
        <img class="w-35" src="/assets/smart-queue-dark.png" alt="smart queue logo">
        <ul class="flex justify-between gap-5 text-(--primary-color)">
            <li><a href="/index.html">Acceuil</a></li>
            <li><a href="/tousServices.html">Services</a></li>
            <li><a href="/commentCaMarche.html">Contacts</a></li>
        </ul>
        <form action=""  class="flex items-center justify-center">
            <div class="flex bg-(--white-color) py-1 px-2 rounded-tl-lg rounded-br-lg top-5 hover:bg-gray-100 shadow-lg">
                <input class="outline-none placeholder-gray-400" type="text" name="" id="" placeholder="ex : carte biométrique">
                <iconify-icon icon="boxicons:search" class="mt-1 text-gray-400 cursor-pointer"></iconify-icon>
            </div>
        </form>
        <div>
            <button class="btn-secondary"><a href="/connexion.html">Se connecter</a></button>
        </div>
    </header>

    <main class="flex w-full">
        <div class="flex flex-col items-start justify-center w-1/2 min-h-screen bg-(--primary-color) gap-5 px-10">
            <p class="text-(--highlight-color)">BON RETOUR</p>
            <h2 class="text-(--white-color) text-4xl font-medium">Récupérez l'accès à votre compte en deux minutes.</h2>
        </div>
        <form class="flex flex-col items-start justify-center w-1/2 min-h-screen gap-2 px-10 text-(--primary-color)">
            <p class="text-(--highlight-color)">ESPACE CLIENT</p>
            <h3 class="text-4xl font-medium">Mot de passe oublié</h3>
            <p class="text-xs">Ça arrive à tout le monde.</p>
            <div class="flex flex-col gap-3 w-full"> 
                <label class="text-xl font-medium">Adresse e-mail</label>
                <input class="border-1 border-w-full p-2 rounded-tl-lg rounded-br-lg bg-(--white-color)" type="text" name="" id="" placeholder="jeandev@gmail.com">                
            </div>
            <p class="text-xs place-self-end">Un code de réinitialisation sera envoyé à cette adresse.</p>
            <div class="flex flex-col w-full gap-5 mt-5 items-center justify-center">
                <input class="btn-primary" type="submit" value="Créer mon compte">
                <a href="connexion.html">← Retour à la <b>connexion</b></a>
            </div>
        </form>
    </main>

    <footer class="bg-linear-to-t from-(--primary-color) to-(--blue-gradient-color) text-(--white-color) px-10 py-20">
        <div class="flex items-start justify-evenly">
            <div>
                <img class="w-40" src="/assets/smart-queue-light.png" alt="smart queue logo">
                <p class="max-w-100 mb-5">Prenez votre ticket où que vous soyez, et laissez l'algorithme gérer votre place dans la file.</p>
                <div class="flex gap-5 text-2xl">
                    <iconify-icon icon="ion:logo-facebook"></iconify-icon>
                    <iconify-icon icon="ion:social-github"></iconify-icon>
                    <iconify-icon icon="ion:social-whatsapp"></iconify-icon>
                    <iconify-icon icon="ion:mail-sharp"></iconify-icon>
                </div>
            </div>
            <div>
                <h4 class="text-xl font-medium mb-5">SERVICES</h4>
                <ul class="flex flex-col gap-3">
                    <li><a href="#">Passeport</a></li>
                    <li><a href="#">Etat civil</a></li>
                    <li><a href="#">Urbanisme</a></li>
                    <li><a href="#">Aide sociale</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-xl font-medium mb-5">COMPTE</h4>
                <ul class="flex flex-col gap-3">
                    <li><a href="#">Se connecter</a></li>
                    <li><a href="#">Créer un compte</a></li>
                    <li><a href="#">Mot de passe oublié ?</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-xl font-medium mb-5">AIDE</h4>
                <ul class="flex flex-col gap-3">
                    <li><a href="#">Comment ça marche ?</a></li>
                    <li><a href="#">Contacts</a></li>
                    <li><a href="#">Mentions légales</a></li>
                </ul>
            </div>
        </div>
        <span class="flex w-[80%] h-px bg-gray-100 place-self-center my-10"></span>
        <p class="place-self-end">© 2026 Smart queue</p>
    </footer>
</body>
</html> 