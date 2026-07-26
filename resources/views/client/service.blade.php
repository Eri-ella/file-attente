<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <script type="module" src="src/main.js"></script>
</head>
<body>
    <section class="text-(--primary-color) p-5">
        <div>
            <button class="btn-secondary mb-10" onclick="history.back()">Retour</button>
        </div>
        <div class="flex flex-col w-full gap-5">
            <div class="flex w-full">
                <div class="flex flex-col gap-5 w-2/3">
                    <h2 class="text-4xl font-medium">Demande d'acte de mariage</h2>
                    <p>Durée moy. 40min</p>
                    <p>Coût. 2000fcfa</p>
                    <p>L'agent de l'état civil vous remet la fiche de demande, vous explique le choix des régimes matrimoniaux (polygamie ou monogamie, communauté ou séparation des biens) et vérifie sommairement votre situation pour vous donner les détails des frais locaux. </p>
                </div>
                <div class="flex flex-col w-1/3">
                    <p class="mb-5 text-(--white-color) bg-(--primary-color) w-fit px-10 py-1 rounded-tl-lg rounded-br-lg">Documents à fournir</p>
                    <ul class="flex flex-col gap-5 pl-5 list-disc">
                        <li>Le formulaire de demande</li>
                        <li>Les actes de naissance</li>
                        <li>Les pièces d'identité</li>
                    </ul>
                </div>
            </div>
            <div>
                <button class="btn-primary mt-5 place-self-center"><a href="#">Réserver un ticket</a></button>
            </div>
        </div>
    </section>
</body>
</html>