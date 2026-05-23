<?php

use Livewire\Volt\Component;
use App\Models\Contact;
use App\Models\Setting;
use App\Mail\ContactRequestMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

new class extends Component {
    // Initialisation propre des propriétés
    public $name = '';
    public $company = '';
    public $email = '';
    public $service = 'Archivage Manuel';
    public $message = '';
    public $captchaToken; // Stocke le jeton généré par Google

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
        'service' => 'required',
        'message' => 'required|min:10',
        'captchaToken' => 'required',
    ];

    protected $messages = [
        'name.required' => 'Le nom est obligatoire.',
        'name.min' => 'Le nom doit contenir au moins 3 caractères.',
        'email.required' => 'L\'adresse email est requise.',
        'email.email' => 'Format d\'email invalide.',
        'message.required' => 'Veuillez saisir votre message.',
        'message.min' => 'Votre message est trop court (min. 10 caractères).',
    ];

    public function send()
    {
        // Validation explicite
        $validated = $this->validate();

        // Vérification du score reCAPTCHA auprès de Google
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_PRIVATE_KEY'),
            'response' => $this->captchaToken,
        ]);

        $score = $response->json()['score'] ?? 0;

        // Si le score est trop bas (0.5 est le standard), on bloque
        if (!$response->json()['success'] || $score < 0.5) {
            $this->dispatch('contact-sent', [
                'type' => 'error',
                'message' => 'Comportement suspect détecté. Veuillez réessayer.'
            ]);
            return;
        }

        try {
            // 1. Sauvegarde en BDD
            Contact::create([
                'name' => $this->name,
                'company' => $this->company,
                'email' => $this->email,
                'service' => $this->service,
                'message' => $this->message,
            ]);

            // 2. Récupération de l'email admin (via cache performant)
            $settings = Setting::getCachedSettings();
            $adminEmail = $settings->email ?? 'contact@polam.cm';

            // 3. Envoi du Mail avec le design Markdown
            Mail::to($adminEmail)->send(new ContactRequestMail($validated));

            $this->reset(['name', 'company', 'email', 'message']);

            // Dispatch pour le Toast SweetAlert2
            $this->dispatch('contact-sent', [
                'type' => 'success',
                'message' => 'Votre demande a été transmise avec succès !'
            ]);

        } catch (\Exception $e) {
            \Log::error("Erreur Contact: " . $e->getMessage());
            $this->dispatch('contact-sent', [
                'type' => 'error',
                'message' => 'Une erreur est survenue lors de l\'envoi.'
            ]);
        }
    }
}; ?>

<div class="font-['DM_Sans',sans-serif]">
    {{-- On utilise wire:submit.prevent pour bloquer le rechargement navigateur --}}
    <form class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div class="md:col-span-1">
            <label class="block text-[10px] font-bold font-['Syne',sans-serif] tracking-[0.18em] uppercase text-gray-500 mb-2">Nom Complet</label>
            <input type="text" wire:model.blur="name" class="w-full px-4 py-2.5 rounded-sm bg-[#F5F6FA] border @error('name') border-red-500 @else border-[#E8EAF0] @enderror outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500 transition-all text-xs text-gray-900">
            @error('name') <span class="text-red-500 text-[10px] mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="md:col-span-1">
            <label class="block text-[10px] font-bold font-['Syne',sans-serif] tracking-[0.18em] uppercase text-gray-500 mb-2">Entreprise</label>
            <input type="text" wire:model.blur="company" class="w-full px-4 py-2.5 rounded-sm bg-[#F5F6FA] border border-[#E8EAF0] outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500 transition-all text-xs text-gray-900">
        </div>

        <div class="md:col-span-1">
            <label class="block text-[10px] font-bold font-['Syne',sans-serif] tracking-[0.18em] uppercase text-gray-500 mb-2">Email Professionnel</label>
            <input type="email" wire:model.blur="email" class="w-full px-4 py-2.5 rounded-sm bg-[#F5F6FA] border @error('email') border-red-500 @else border-[#E8EAF0] @enderror outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500 transition-all text-xs text-gray-900">
            @error('email') <span class="text-red-500 text-[10px] mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="md:col-span-1">
            <label class="block text-[10px] font-bold font-['Syne',sans-serif] tracking-[0.18em] uppercase text-gray-500 mb-2">Service d'intérêt</label>
            <select wire:model.change="service" class="w-full px-4 py-2.5 rounded-sm bg-[#F5F6FA] border border-[#E8EAF0] outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500 transition-all text-xs text-gray-900">
                <option value="Énergie solaire">Énergie solaire</option>
                <option value="Vidéosurveillance">Vidéosurveillance</option>
                <option value="Installation électrique">Installation électrique</option>
                <option value="Maintenance biomédicale">Maintenance biomédicale</option>
                <option value="Réseaux & Télécoms">Réseaux & Télécoms</option>
                <option value="Maintenance IT">Maintenance IT</option>
                <option value="Autre">Autre</option>
            </select>
        </div>

        <div class="md:col-span-2">
            <label class="block text-[10px] font-bold font-['Syne',sans-serif] tracking-[0.18em] uppercase text-gray-500 mb-2">Votre Message</label>
            <textarea wire:model.blur="message" rows="4" class="w-full px-4 py-2.5 rounded-sm bg-[#F5F6FA] border @error('message') border-red-500 @else border-[#E8EAF0] @enderror outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500 transition-all text-xs text-gray-900"></textarea>
            @error('message') <span class="text-red-500 text-[10px] mt-1">{{ $message }}</span> @enderror
        </div>

        {{-- Champ caché pour le token --}}
        <input type="hidden" wire:model="captchaToken" id="captchaToken">

        <div class="md:col-span-2 mt-2">
            <button type="submit"
                    wire:loading.attr="disabled"
                    wire:target="send"
                    class="w-full bg-orange-500 text-white font-['Syne',sans-serif] font-bold text-xs uppercase tracking-wider py-3.5 rounded-sm hover:bg-[#EA580C] disabled:opacity-50 disabled:cursor-not-allowed transition-all shadow-sm active:scale-[0.98]">

                <span wire:loading.remove wire:target="send" class="inline-flex items-center justify-center gap-2">
                    Envoyer la demande
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </span>

                <span wire:loading wire:target="send" class="inline-flex items-center justify-center gap-2">
                    <span>Traitement en cours...</span>
                </span>
            </button>
        </div>
    </form>

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('contact-sent', (event) => {
                const data = event[0];
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'font-["DM_Sans",sans-serif] rounded-sm border border-[#E8EAF0] shadow-sm',
                        title: 'font-["Syne",sans-serif] font-bold text-xs'
                    }
                });
                Toast.fire({
                    icon: data.type,
                    title: data.message,
                    background: data.type === 'success' ? '#FFF7ED' : '#FEF2F2',
                    color: data.type === 'success' ? '#EA580C' : '#991B1B',
                });
            });

            // LOGIQUE RECAPTCHA
            const form = document.querySelector('form');
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                grecaptcha.ready(function() {
                    grecaptcha.execute('{{ env("RECAPTCHA_PUBLIC_KEY") }}', {action: 'contact'}).then(function(token) {
                        @this.set('captchaToken', token);
                        @this.send();
                    });
                });
            });
        });
    </script>
</div>
