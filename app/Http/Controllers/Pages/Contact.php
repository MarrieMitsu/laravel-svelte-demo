<?php

namespace App\Http\Controllers\Pages;

use App\Actions\Contact\CreateContact;
use App\Actions\Contact\DeleteContact;
use App\Actions\Contact\GetContactList;
use App\Actions\Contact\UpdateContact;
use App\Errors\ClientError;
use App\Errors\ServerError;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Http\Resources\ContactResource;
use App\Http\Responses\NotificationResponse;
use App\Models\Contact as ModelsContact;
use Illuminate\Http\Request;
use Inertia\Inertia;

class Contact extends Controller
{
    public function view(Request $request)
    {
        $payload = collect($request->query())
            ->only(['name', 'email', 'limit']);

        [$_, $res] = GetContactList::run($payload);

        return Inertia::render('Contact/Contact', [
            'contacts' => ContactResource::collection($res),
        ]);
    }

    public function createContact(CreateContactRequest $request)
    {
        $payload = collect($request->safe()->only('name', 'email'));

        [$err, $res] = CreateContact::run($payload);

        if ($err instanceof ClientError) {
            return to_route('Contact.view')->with([
                'notification' => NotificationResponse::error($err->message),
            ]);
        } else if ($err instanceof ServerError) {
            return to_route('Contact.view')->with([
                'notification' => NotificationResponse::error('Something went wrong!'),
            ]);
        }

        return to_route('Contact.view')->with([
            'notification' => NotificationResponse::success(
                'Contact saved!',
            ),
        ]);
    }

    public function updateContact(UpdateContactRequest $request, int $id)
    {
        $payload = collect($request->safe()->only('name', 'email'));

        [$err, $_] = UpdateContact::run($id, $payload);

        if ($err instanceof ClientError) {
            return to_route('Contact.view')->with([
                'notification' => NotificationResponse::error($err->message),
            ]);
        } else if ($err instanceof ServerError) {
            return to_route('Contact.view')->with([
                'notification' => NotificationResponse::error('Something went wrong!'),
            ]);
        }

        return to_route('Contact.view')->with([
            'notification' => NotificationResponse::success(
                'Contact saved!',
            ),
        ]);
    }

    public function deleteContact(Request $request, int $id)
    {
        [$err, $_] = DeleteContact::run($id);

        if ($err instanceof ClientError) {
            return to_route('Contact.view')->with([
                'notification' => NotificationResponse::error($err->message),
            ]);
        } else if ($err instanceof ServerError) {
            return to_route('Contact.view')->with([
                'notification' => NotificationResponse::error('Something went wrong!'),
            ]);
        }

        return to_route('Contact.view')->with([
            'notification' => NotificationResponse::success(
                'Contact deleted!',
            ),
        ]);
    }

    public function seedContact(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
        ]);

        $amount = $request->input('amount');

        if (is_numeric($amount) && $amount > 0) {
            ModelsContact::factory()->count($amount)->create();
        }

        return to_route('Contact.view')->with([
            'notification' => NotificationResponse::info(
                'Seeding!',
            ),
        ]);
    }
}
