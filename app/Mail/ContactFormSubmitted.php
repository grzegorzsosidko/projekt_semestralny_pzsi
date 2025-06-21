<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Auth\User;

class ContactFormSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Zdefiniowaliśmy nasze właściwości tutaj, aby były łatwo dostępne w całej klasie.
     */
    public User $user;
    public string $category;
    public string $messageContent;
    private array $uploadedFiles; // Zmieniliśmy na prywatną właściwość o innej nazwie

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, string $category, string $messageContent, array $attachments)
    {
        // Ręcznie przypisujemy wartości w konstruktorze
        $this->user = $user;
        $this->category = $category;
        $this->messageContent = $messageContent;
        $this->uploadedFiles = $attachments;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address($this->user->email, $this->user->name),
            subject: 'Nowe zgłoszenie z intranetu: ' . $this->category,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // Przekazujemy publiczne właściwości do widoku, aby można było ich tam użyć
        return new Content(
            view: 'emails.contact-form',
            with: [
                'userName' => $this->user->name,
                'userEmail' => $this->user->email,
                'emailCategory' => $this->category,
                'emailMessage' => $this->messageContent,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachmentList = [];

        // Używamy naszej prywatnej właściwości do iteracji po plikach
        foreach ($this->uploadedFiles as $attachment) {
            $attachmentList[] = Attachment::fromPath($attachment->getRealPath())
                ->as($attachment->getClientOriginalName())
                ->withMime($attachment->getClientMimeType());
        }

        return $attachmentList;
    }
}
