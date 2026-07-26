<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket</title>
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


    <main class="flex flex-col items-center text-(--primary-color) min-h-screen">
        <div class="flex flex-col items-center justify-center w-full min-h-50 bg-(--primary-color) gap-5">
            <p class="text-(--highlight-color)">Votre tour approche</p> <!-- votre ticket est ne cours de traitement -->
            <p class="text-(--white-color) text-7xl font-medium">00:12:40</p> <!-- --:--:-- -->
            <p class="text-(--white-color)">Temps restant avant le passage</p>
        </div>
        <div class="flex w-full justify-center gap-10 mb-10">
            <table class="min-w-70">
                <tbody class="flex flex-col gap-5">
                    <tr class="flex justify-between">
                        <td>Service</td>
                        <td>Demande d'acte de mariage</td>
                    </tr>
                    <tr class="flex justify-between">
                        <td>Date</td>
                        <td>18 juillet 2026</td>
                    </tr>
                    <tr class="flex justify-between">
                        <td>Heure</td>
                        <td>14:20</td>
                    </tr>
                    <tr class="flex justify-between">
                        <td>Titulaire</td>
                        <td>dolo.chou@gmail.fr</td>
                    </tr>
                </tbody>
            </table>
            <div class="flex flex-col justify-center items-center bg-[#d2b58975] border-l-3 border-(--primary-color) border-dashed min-w-30 gap-2 mb-10">
                <p class="text-4xl font-medium">B-042</p>
                <p class="text-xs">Votre ticket</p>
            </div>
        </div>
        <table class="w-70 border-1 border-(--primary-color) mb-10">
            <tbody>
                <tr>
                    <td class="font-light">04</td>
                    <td>Ticket B-039</td>
                    <td class="uppercase bg-[#d2b58975]">En cours</td>
                </tr>
            </tbody>
        </table>
        <div class="flex flex-col justify-center gap-5">
            <h3 class="text-xl font-medium">Mes tickets</h3>
            <table class="w-70 border-1 border-(--primary-color) p-5">
                <tbody>
                    <tr>
                        <td>Ticket B-039</td>
                        <td class="bg-[#222D5275]">non confirmé</td>
                    </tr>
                </tbody>
            </table>
        </div>
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