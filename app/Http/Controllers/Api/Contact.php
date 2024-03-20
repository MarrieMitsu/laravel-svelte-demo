<?php

namespace App\Http\Controllers\Api;

use App\Actions\Contact\CreateContact;
use App\Actions\Contact\DeleteContact;
use App\Actions\Contact\GetContactList;
use App\Actions\Contact\UpdateContact;
use App\Errors\ClientError;
use App\Errors\ServerError;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContactResource;
use Illuminate\Http\Request;

class Contact extends Controller
{
    public function getContactList(Request $request)
    {
        $request->validate([
            'name' => 'string',
            'email' => 'sometimes|email',
            'limit' => 'sometimes|integer',
        ]);

        $payload = collect($request->only('name', 'email', 'limit'))
            ->recursive();

        [$err, $contacts] = GetContactList::run($payload);

        if ($err instanceof ClientError) {
            abort($err->code, $err->message);
        } else if ($err instanceof ServerError) {
            abort(500, 'Internal server error.');
        }

        return ContactResource::collection($contacts);
    }

    public function createContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
        ]);

        $payload = collect($request->only('name', 'email'))
            ->recursive();

        [$err, $res] = CreateContact::run($payload);

        if ($err instanceof ClientError) {
            abort($err->code, $err->message);
        } else if ($err instanceof ServerError) {
            abort(500, 'Internal server error.');
        }

        return (new ContactResource($res))->response()->setStatusCode(201);
    }

    public function updateContact(Request $request, int $id)
    {
        $request->validate([
            'name' => 'string',
            'email' => 'sometimes|email',
        ]);

        $payload = collect($request->only('name', 'email'))
            ->recursive();

        [$err, $_] = UpdateContact::run($id, $payload);

        if ($err instanceof ClientError) {
            abort($err->code, $err->message);
        } else if ($err instanceof ServerError) {
            abort(500, 'Internal server error.');
        }

        return response()->noContent();
    }

    public function deleteContact(Request $request, int $id)
    {
        [$err, $_] = DeleteContact::run($id);

        if ($err instanceof ClientError) {
            abort($err->code, $err->message);
        } else if ($err instanceof ServerError) {
            abort(500, 'Internal server error.');
        }

        return response()->noContent();
    }
}
