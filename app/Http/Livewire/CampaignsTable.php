<?php

namespace App\Http\Livewire;

use App\Models\CampaignNotif;
use App\Models\Campaign;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;

class CampaignsTable extends LivewireDatatable
{
    public $model = Campaign::class;
    public $campaign;
    public $campaign_id;
    public $campaign_template_id;
    public $name;
    public $description;
    public $modalAction = '';


    public function builder()
    {
        return CampaignNotif::query()
            ->leftJoin('campaigns','campaigns.id', 'campaign_notifs.campaign_id')
            ->orderByDesc('campaigns.created_at')
            ->groupBy('campaign_id');
    }

    public function columns()
    {
        return [
            Column::checkbox(),
            Column::callback(['id'], function ($id) { return view('campaigns.actions', ['id' => $id]); }),
            NumberColumn::name('campaign_id')->label(__('Number'))->alignCenter(),
            Column::name('campaigns.name')->filterable()->searchable(),
            Column::name('campaigns.email')->label(__('From'))->filterable()->searchable(),
            DateColumn::name('campaigns.created_at')->format('d M H:i')->label(__('Started'))->filterable(),
            NumberColumn::raw('count(campaign_id)')->label(__('Total'))->alignRight(),
            NumberColumn::raw('sum(sent)')->label(__('Sent'))->alignRight(),
            NumberColumn::raw('sum(open)')->label(__('Opened'))->alignRight(),
            NumberColumn::raw('sum(click)')->label(__('Clicked'))->alignRight(),
            NumberColumn::raw('sum(bounce)')->label(__('Bounce'))->alignRight(),
            NumberColumn::raw('sum(spam)')->label(__('Spam'))->alignRight(),
            NumberColumn::raw('sum(blocked)')->label(__('Blocked'))->alignRight(),
            NumberColumn::raw('sum(unsub)')->label(__('Unsubscribed'))->alignRight(),
        ];
    }

    /*
     * Database Actions (SCRUD): Select, Read, Create, Update, Delete
     */
    public function index()
    {
//        $campaigns = Campaign::all();
        $campaigns = $this->builder();
        return view('campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        Campaign::create($this->validate(Campaign::validationRules()));
        $this->closeModal();
    }

    public function update()
    {
        $this->campaign->update($this->validate(Campaign::validationRules()));
        $this->closeModal();
    }

    public function destroy()
    {
        $this->campaign->delete();
        $this->closeModal();
    }

    /*
     * Modal form functions
     */
    public function closeModal()
    {
        $this->dispatchBrowserEvent('close-modal-event');
    }

    public function openModal($action, $id = 0)
    {
        $this->modalAction = $action;
        $this->resetErrorBag();

        if (0 == $id) {
            $this->campaign_id          = null;
            $this->campaign_template_id = null;
            $this->name                 = null;
            $this->description          = null;
        } else {
            $this->campaign             = Campaign::findOrFail($id);
            $this->campaign_id          = $id;
            $this->campaign_template_id = $this->campaign->campaign_template_id;
            $this->name                 = $this->campaign->name;
            $this->description          = $this->campaign->description;
        }

        $this->dispatchBrowserEvent('open-modal-event');
    }
}
