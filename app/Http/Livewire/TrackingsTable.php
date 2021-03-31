<?php

namespace App\Http\Livewire;

use App\Models\Tracking;
use Illuminate\Http\Request;
use libphonenumber\RegionCode;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class TrackingsTable extends LivewireDatatable
{
    public $model = Tracking::class;
    public $tracking;
    public $tracking_id;
    public $ip;
    public $user_agent;
    public $ip_user;
    public $ip_for;
    public $country;
    public $region;
    public $city;
    public $city_lat_long;
    public $modalAction = '';

    public function builder()
    {
        return Tracking::query()
            ->leftJoin('contacts' , 'contacts.id' , 'trackings.contact_id');
    }

    public function columns()
    {
        return [
            Column::checkbox(),
            Column::callback(['id'], function ($id) { return view('trackings.actions', ['id' => $id]); }),
            DateColumn::name('created_at')->format('d M H:i')->label(__('date'))->filterable()->defaultSort('desc'),
            Column::name('contacts.name')->label(__('Contact'))->filterable(),
            Column::name('name')->filterable()->searchable()->label(__('URI')),
            Column::name('country')->filterable()->searchable(),
            Column::name('region')->filterable()->searchable(),
            Column::name('city')->filterable()->searchable(),
            //Column::name('ip')->filterable()->searchable(),
            //Column::name('ip_user')->filterable()->searchable(),
            Column::name('ip_for')->filterable()->searchable(),
            Column::name('user_agent')->truncate()->filterable()->searchable(),
            // Column::name('city_lat_long')->filterable()->searchable(),
        ];
    }

    /*
     * Database Actions (SCRUD): Select, Read, Create, Update, Delete
     */
    public function index()
    {
        $trackings = Tracking::all();
        return view('trackings.index', compact('trackings'));
    }

    public function create()
    {
        Tracking::create($this->validate(Tracking::validationRules()));
        $this->closeModal();
    }

    public function update()
    {
        $this->tracking->update($this->validate(Tracking::validationRules()));
        $this->closeModal();
    }

    public function destroy()
    {
        $this->tracking->delete();
        $this->closeModal();
    }

    /*
     * Modal form functions
     */
    public function closeModal()
    {
        $this->dispatchBrowserEvent('close-modal-event');
    }

    public function openModal($action, $id=0)
    {
        $this->modalAction = $action;
        // $this->readonly = '';
        // if( 'readonly' == $this->modalAction )  $this->readonly = 'readonly';
        $this->resetErrorBag();

        if( 0 == $id ) {
            $this->ip               = null;
            $this->ip_user          = null;
            $this->user_agent       = null;
            $this->country          = null;
            $this->city             = null;
            $this->city_lat_long    = null;
        }
        else {
            $this->tracking         = Tracking::findOrFail($id);
            $this->tracking_id      = $id;
            $this->ip               = $this->tracking->ip;
            $this->ip_user          = $this->tracking->ip_user;
            $this->ip_for           = $this->tracking->ip_for;
            $this->user_agent       = $this->tracking->user_agent;
            $this->country          = $this->tracking->country;
            $this->region           = $this->tracking->region;
            $this->city             = $this->tracking->city;
            $this->city_lat_long    = $this->tracking->city_lat_long;
        }

        $this->dispatchBrowserEvent('open-modal-event');
    }

    public static function store(Request $request, $contact_id = null)
    {
        try {
            Tracking::create([
                'contact_id'        => $contact_id,
                'name'              => $request->getRequestUri(),
                'ip'                => $request->ip(),
                'user_agent'        => $request->userAgent(),
                'accept_language'   => $request->header("accept-language"),
                'ip_user'           => $request->header("X-Forwarded-User-Ip"),
                'ip_for'            => $request->header("X-Forwarded-For"),
                'country'           => $request->header("X-AppEngine-Country"),
                'region'            => $request->header("X-AppEngine-Region"),
                'city'              => $request->header("X-AppEngine-City"),
                'city_tat_long'     => $request->header("X-AppEngine-CityLatLong"),
            ]);
        }
        catch (\Throwable $e) { }
    }

    public function deleteAll()
    {
        Tracking::destroy($this->selected);
        $this->closeModal();
    }
}
