<?php

namespace App\Actions\Contact;

use App\Errors\ServerError;
use App\Models\Contact;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class GetContactList
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
     *   limit?: int
     * }
     *
     * @return [$err: ?mixed, $res: Collection<Contact>]
     */
    public function handle(Collection $payload): array
    {
        $err = null;
        $res = collect([]);

        try {
            $res = Contact::when($payload->get('name'), function (
                Builder $query,
                string $val,
            ) {
                $query->where('name', 'like', "%{$val}%");
            })->when($payload->get('email'), function (
                Builder $query,
                string $val,
            ) {
                $query->where('email', 'like', "%{$val}%");
            })->latest()
                ->simplePaginate($payload->get('limit', 10));
        } catch (Exception $e) {
            $err = new ServerError(500, $e->getMessage());
        }

        return [$err, $res];
    }
}
