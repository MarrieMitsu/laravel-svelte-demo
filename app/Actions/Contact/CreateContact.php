<?php

namespace App\Actions\Contact;

use App\Errors\ClientError;
use App\Errors\ServerError;
use App\Models\Contact;
use Exception;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateContact
{
    use AsAction;

    /**
     * handle
     *
     * Payload Scheme:
     *
     * Payload {
     *   name: string
     *   email: string
     * }
     *
     * @return [$err: ?mixed, $res: ?Contact]
     */
    public function handle(Collection $payload): array
    {
        $err = null;
        $res = null;

        if (!$payload->get('name')) {
            $err = new ClientError(422, 'Name is required.');
            return [$err, $res];
        }

        if (!$payload->get('email')) {
            $err = new ClientError(422, 'Email is required.');
            return [$err, $res];
        }

        try {
            $res = Contact::create($payload->all());
        } catch (Exception $e) {
            $err = new ServerError(500, $e->getMessage());
        }

        return [$err, $res];
    }
}
