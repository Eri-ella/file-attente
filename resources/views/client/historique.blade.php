<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique</title>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    @vite(['public/js/client.js'])
</head>
<body>
    <div class="min-h-screen flex flex-col justify-evenly items-center text-(--primary-color)">
        <h2 class="text-4xl font-medium">Historique des tickets</h2>
        <table class="flex flex-col border-1 border-(--primary-color)">
            <thead>
                <tr class="grid grid-cols-4 place-items-center mb-5">
                    <th>TICKET</th>
                    <th>SERVICE</th>
                    <th>DATE</th>
                    <th>STATUT</th>
                </tr>
            </thead>    
            <tbody>    
                <tr class="grid grid-cols-4 place-items-center border-t-1">
                    <td>B-040</td>
                    <td>Renouvellement de passeport</td>
                    <td>18 juil. 2026</td>
                    <td>EN ATTENTE</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>