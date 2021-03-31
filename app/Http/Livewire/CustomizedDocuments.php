<?php

namespace App\Http\Livewire;

use App\Models\CampaignTemplate;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use MBence\OpenTBSBundle\Services\OpenTBS;
use Illuminate\Support\Arr;
use Google\Cloud\Storage\StorageClient;


class CustomizedDocuments extends Component
{
    public function customizeCMContract( $mergeInfos, $file )
    {
        $dir        = 'attachments';

        $disk       = Storage::disk( config('filesystems.default') );
        $bucketName = config('filesystems.disks.gcs.bucket');
        $storage    = new StorageClient(['projectId' => 'molitor-partners']);
        $bucket     = $storage->bucket($bucketName);

        $storage->registerStreamWrapper('gs');


//        $disk->makeDirectory( $dir );
        $temp   = pathinfo($file, PATHINFO_FILENAME) .'_'. Arr::get($mergeInfos,'firstname') .'.'. pathinfo($file, PATHINFO_EXTENSION);
        $in     = Storage::path( $dir .'/'. $file );
        $out    = Storage::path( $dir .'/'. $temp );

// $in      = 'gs://'. $bucketName .'/'. $dir .'/'. $file;
        $in      = 'https://storage.cloud.google.com/molitor_dev/attachments/ConcilMember_Contract_v3.docx';
        $out     = 'https://storage.cloud.google.com/molitor_dev/attachments/ConcilMember_Contract_v3_Manuel.docx';

        $tbs = new OpenTBS;
        $tbs->LoadTemplate( $in, OPENTBS_ALREADY_UTF8 );
        $tbs->MergeField('contacts', $mergeInfos );
        $tbs->Show(OPENTBS_FILE, $out);

        return $out;


        Log::debug('$disk: ' . $disk->get('/') );

        if( Storage::exists( $in ) ) {
            Log::debug('$in: ' . $in );
        }
/*
        foreach ($bucket->objects() as $object) {
            Log::debug('$object->name(): ' . $object->name() );
        }
*/
        Log::debug('$out: ' . $out );

        if( Storage::exists( $out ) ) {
            Log::debug('file exists: ' . $out);
        } else {
            $tbs = new OpenTBS;
            $tbs->LoadTemplate( $in, OPENTBS_ALREADY_UTF8 );
            $tbs->MergeField('contacts', $mergeInfos );
            $tbs->Show(OPENTBS_FILE, $out);
        }

        return $out;
    }
}
