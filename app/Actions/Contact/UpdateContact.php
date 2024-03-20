<?php

namespace App\Actions\Contact;

use App\Errors\ClientError;
use App\Errors\ServerError;
use App\Models\Contact;
use Exception;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateContact
{
    use AsAction;

    /**
     * handle
     *
     * Payload Scheme:
     *
     * Payload {
     *   name?: string
     *   email?: string
     * }
     *
     * @return [$err: ?mixed, $res: null]
     */
    public function handle(int $id, Collection $payload): array
    {
        $err = null;
        $res = null;

        try {
            $contact = Contact::find($id);

            if (!$contact) {
                $err = new ClientError(400, 'Contact not found.');
                return [$err, $res];
            }

            $contact->update($payload->all());
        } catch (Exception $e) {
            $err = new ServerError(500, $e->getMessage());
        }

        return [$err, $res];
    }
}
