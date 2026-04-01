@component('mail::message')
# Nouvelle demande de contact

Un client potentiel a envoyé un message depuis le site **{{ config('app.name') }}**.

**Détails du contact :**
- **Nom :** {{ $data['name'] }}
- **Entreprise :** {{ $data['company'] ?? 'Non précisée' }}
- **Email :** {{ $data['email'] }}
- **Service :** {{ $data['service'] }}

**Message :**
{{ $data['message'] }}

@component('mail::button', ['url' => config('app.url') . '/admin/contacts'])
Voir dans l'administration
@endcomponent

Merci,<br>
L'équipe {{ config('app.name') }}
@endcomponent
