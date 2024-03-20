<?php

namespace App\Actions\Contact;

use App\Errors\ServerError;
use App\Models\Contact;
use Exception;
use Lorisleiva\Actions\Concerns\AsAction;

class DeleteContact
{
    use AsAction;

    /**
     * handle
     *
     * @return [$err: ?mixed, $res: null]
     */
    public function handle(int $id): array
    {
        $err = null;
        $res = null;

        try {
            Contact::destroy($id);
        } catch (Exception $e) {
            $err = new ServerError(500, $e->getMessage());
        }

        return [$err, $res];
    }
}
