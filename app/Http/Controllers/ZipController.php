<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use ZipArchive;

class ZipController extends Controller
{
    private function extract($zipName)
    {
        $zipPath = storage_path("app/zips/$zipName");
        $extractPath = storage_path("app/tmp/$zipName");

        // 🔍 Vérifier que le zip existe
        if (! file_exists($zipPath)) {
            abort(404, 'ZIP introuvable: '.$zipPath);
        }

        // créer dossier si pas existe
        if (! file_exists($extractPath)) {
            mkdir($extractPath, 0777, true);
        }

        $zip = new ZipArchive;
        $status = $zip->open($zipPath);

        // 🔥 DEBUG IMPORTANT
        if ($status !== true) {
            abort(500, 'Erreur ouverture ZIP: '.$status);
        }

        $zip->extractTo($extractPath);
        $zip->close();

        return $extractPath;
    }

    public function tree($zip)
    {
        $path = $this->extract($zip);

        $files = collect(File::allFiles($path))
            ->map(fn ($f) => $f->getRelativePathname())
            ->values();

        return response()->json($files);
    }

    public function file(Request $request, $zip)
    {
        $base = $this->extract($zip);
        $file = realpath($base.'/'.$request->query('path'));

        // 🔒 sécurité
        if (! $file || ! str_starts_with($file, $base) || ! is_file($file)) {
            abort(403);
        }

        return response()->file($file);
    }

    public function view()
    {
        $code = "print('hello world')";
        $language = 'python';

        return view('zip-view', compact('code', 'language'));
    }
}
