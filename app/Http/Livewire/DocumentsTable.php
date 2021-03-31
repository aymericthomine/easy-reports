<?php

namespace App\Http\Livewire;

use App\Models\Document;
use DocuSign\eSign\Model\Signer;
use DocuSign\eSign\Model\SignHere;
use DocuSign\eSign\Model\Tabs;
use Globalis\Universign\Request\TransactionSigner;
use \Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use LaravelDocusign\Facades\DocuSign;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Livewire\WithFileUploads;
use App\Http\Livewire\CustomizedDocuments;

use MBence\OpenTBSBundle\Services\OpenTBS;
use clsOpenTBS;
use clsTinyButStrong;

use App\Http\Requests;
use Illuminate\Http\Request;

use Mobile_Detect;

class DocumentsTable extends LivewireDatatable
{
    use WithFileUploads;

    public $model = Document::class;
    public $document;
    public $document_id;
    public $name;
    public $description;
    public $format;
    public $version;
    public $file;
    public $modalAction;
    public $temp;

    public function columns()
    {
        return [
            Column::checkbox(),
            Column::callback(['id'], function ($id) { return view('documents.actions', ['id' => $id]); }),
            Column::name('name')->label(__('Name'))->filterable()->searchable()->editable()->defaultSort('asc'),
            Column::name('description')->filterable()->searchable()->editable()->defaultSort('asc'),
            NumberColumn::name('format')->filterable()->defaultSort('asc'),
            NumberColumn::name('version')->filterable()->defaultSort('asc'),
        ];
    }

    /*
 * Database Actions (SCRUD): Select, Read, Create, Update, Delete
 */
    public function index()
    {
        $documents = Document::all();
        return view('documents.index', compact('documents'));
    }

    public function create()
    {
        $this->file->store('upload');
        $this->file = base64_encode(file_get_contents($this->file->getRealPath()));

        Document::create($this->validate(Document::validationRules()));
        $this->closeModal();
    }

    public function update()
    {
        $this->file->store('upload');
        $this->file = base64_encode(file_get_contents($this->file->getRealPath()));

        $this->document->update($this->validate(Document::validationRules()));
        $this->closeModal();
    }

    public function destroy()
    {
        $this->document->delete();
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
        $this->resetErrorBag();

        if( 0 == $id ) {
            $this->document_id  = null;
            $this->name         = null;
            $this->description  = null;
            $this->format       = null;
            $this->version      = null;
            $this->file         = null;
        }
        else {
            $this->document     = Document::findOrFail($id);
            $this->document_id  = $id;
            $this->name         = $this->document->name;
            $this->description  = $this->document->description;
            $this->format       = $this->document->format;
            $this->version      = $this->document->version;
            $this->file         = $this->document->file;
            $this->temp         = tempnam(sys_get_temp_dir(),'MP_doc_');
//            $this->temp       = tempnam(realpath('storage'),'MP_doc_');
            file_put_contents( $this->temp, base64_decode($this->file) );
        }

        $this->dispatchBrowserEvent('open-modal-event');
    }

    public static function getLastCMContract()
    {
        $ContractName = 'CSI Molitor Partners CM 12 10 20 FR.docx';

        $contract = sys_get_temp_dir() . '/' . $ContractName;
        //$contract = realpath('storage') . '/' . $ContractName;
        $file = Document::where('name', $ContractName)->first()->file;
        file_put_contents( $contract, base64_decode($file) );
        return $contract;
    }

    public function download()
    {
        return response()->download($this->temp, $this->name);
        // $headers = array('Content-Type' => File::mimeType($this->temp));
        // return response()->download($this->temp, $this->name, $headers );
    }

    public function updatedFile()
    {
        $this->validate([
            'file' => 'required|mimes:doc,docx,csv,txt,xls,pdf|max:1024',
        ]);
        $this->name = $this->file->getClientOriginalName();
        $this->format = $this->file->getClientOriginalExtension();
        $this->version = 1;
    }

    public function dragAndDrop(Request $request)
    {
        $this->file = $request->file('file');
        $this->name = $this->file->getClientOriginalName();
        $this->description = $this->name;
        $this->format = $this->file->getClientOriginalExtension();
        $this->version = 1;

        //$this->file->move(realpath('storstorageage'),$this->name);
        //$this->store();

        $this->file = base64_encode(file_get_contents($this->file->getRealPath()));

        Document::create($this->validate(Document::validationRules()));
        return response()->json(['success'=>$this->name]);
    }

    public function sign($id)
    {
//        $this->description = DocuSign::get('folders')->list();

//        $client = new YouSignApiClientLaravel();

        $signer1 = new TransactionSigner();
        $signer1
            ->setFirstname('Jean')
            ->setLastname('Dupond')
            ->setPhoneNum('0999999999')
            ->setEmailAddress('jean.dupond@example.com')
            ->setSuccessURL('https://www.universign.eu/fr/sign/success/')
            ->setCancelURL('https://www.universign.eu/fr/sign/cancel/')
            ->setFailURL('https://www.universign.eu/fr/sign/failed/')
            ->setProfile('profil_vendeur');

        $doc = base64_decode($this->file);
        //$client = DocuSign::create();
        $client = new DocuSign([
            'username'       => env('DOCUSIGN_USERNAME'),
            'password'       => env('DOCUSIGN_PASSWORD'),
            'integrator_key' => env('DOCUSIGN_INTEGRATOR_KEY'),
            'host'           => env('DOCUSIGN_HOST')
        ]);
        $document1 = new \DocuSign\eSign\Model\Document([  # create the DocuSign document object
            'document_base64' => $doc,
            'name' => 'Test Document',  # can be different from actual file name
            'file_extension' => 'pdf',  # many different document types are accepted
            'document_id' => '1',  # a label used to reference the doc
            // 'client_user_id' => $clientUserId
        ]);
        $signer1 = new Signer([
            'email' => "manuel@dubosc.fr", 'name' => "Manuel Dubosc",
            'recipient_id' => "1", 'routing_order' => "1"
        ]);
        $sign_here1 = new SignHere(['document_id' => '1', 'page_number' => '1', 'recipient_id' => '1',
            'tab_label' => 'SignHereTab', 'x_position' => '35', 'y_position' => '680'
        ]);
        $signer1->setTabs(new Tabs([
            'sign_here_tabs' => [$sign_here1]
        ]));
    }
}
