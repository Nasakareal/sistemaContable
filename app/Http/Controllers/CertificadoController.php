<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificadoController extends Controller
{
    public function generarP12(Request $request)
    {
        $request->validate([
            'cer' => 'required|file|mimes:cer,crt',
            'key' => 'required|file|mimes:key',
            'password' => 'required|string',
        ]);

        $cerPath = $request->file('cer')->store('temp');
        $keyPath = $request->file('key')->store('temp');

        $certContent = file_get_contents(storage_path("app/$cerPath"));
        $keyContent = file_get_contents(storage_path("app/$keyPath"));
        $keyPass = $request->password;

        $cert = openssl_x509_read($certContent);
        $pkey = openssl_pkey_get_private($keyContent, $keyPass);

        if (!$cert || !$pkey) {
            return back()->with('error', 'Error al leer certificado o clave privada.');
        }

        $p12 = null;
        $p12Pass = 'firma123';

        $ok = openssl_pkcs12_export($cert, $p12, $pkey, $p12Pass);
        if (!$ok) {
            return back()->with('error', 'No se pudo generar el archivo P12.');
        }

        $filename = 'certificado_' . time() . '.p12';
        Storage::put("p12/$filename", $p12);

        Storage::delete([$cerPath, $keyPath]);

        return response()->download(storage_path("app/p12/$filename"))->deleteFileAfterSend(true);
    }
}
