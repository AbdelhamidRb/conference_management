<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Invitation en tant que co-président</title>
</head>

<body>
    <p>Bonjour {{ $user->firstName }} {{ $user->lastName }},</p>

    <p>
        Vous avez été ajouté en tant que <strong>co-président</strong> pour la conférence
        <strong>{{ $conference->nom }}</strong> ({{ $conference->acronyme }}).
    </p>

    <p>
        N’hésitez pas à consulter régulièrement la plateforme pour suivre les actualités et tâches liées à la conférence.
    </p>

    <p>Bien cordialement,<br>L'équipe d'organisation</p>
</body>

</html>