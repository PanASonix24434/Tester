<?php

namespace App\Http\Controllers\ProfileVesel;

use Illuminate\Http\Request;
use App\Models\Vessel;
use App\Http\Controllers\Controller;
use App\Models\ProfilVessel\AmVessel;
use App\Models\ProfilVessel\Lesen;
use App\Models\ProfilVessel\Kulit;
use App\Models\ProfilVessel\Enjin;
use App\Models\ProfilVessel\PendaftaranAntarabangsa;
use App\Models\CmEquipment;
use App\Models\nd_Lpi_Report;
use App\Models\ProfilVessel\Pemilikan;
use App\Models\ProfilVessel\Kru;
use App\Models\ProfilVessel\Kesalahan;
use App\Models\ProfilVessel\ListingPendaratan;
use App\Models\ProfilVessel\Pematuhan;
use App\Models\ProfilVessel\Muatan;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Colors\Profile;
use App\Models\ProfileUsers;

class ProfileVeselController extends Controller
{
    /**
     * Show all vessels.
     * @return \Illuminate\Http\Response The view of the vessel profile
     */
    public function index(Request $request)
    {
        $query = Vessel::query()
            ->leftJoin('pemilikan', 'vessels.no_pendaftaran', '=', 'pemilikan.no_pendaftaran')
            ->select('vessels.*', 'pemilikan.no_ic_atau_syarikat');

        $user = Auth::user();
        $profileUsers = ProfileUsers::where('icno', $user->username)->first();

        // Restrict access based on role
        if (!$user->is_admin) {
            if ($profileUsers) {
                // Assuming 'managers' is a relationship on the Vessel model
                $query->whereHas('managers', function ($q) use ($profileUsers) {
                    $q->where('profile_user_id', $profileUsers->id);
                });
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        $request->validate([
            'no_pendaftaran' => 'nullable|string|max:255',
            'no_ic_syarikat' => 'nullable|string|max:255',
            'negeri' => 'nullable|string|max:100',
            'daerah' => 'nullable|string|max:100',
            'pangkalan' => 'nullable|string|max:100',
            'zon' => 'nullable|string|max:50',
            'status_vesel' => 'nullable|integer'
        ]);

        // Filter by No. Vesel
        if ($request->no_pendaftaran) {
            $query->where('vessels.no_pendaftaran', 'like', '%' . $request->no_pendaftaran . '%');
        }

        // Filter by No. IC/Syarikat
        if ($request->no_ic_syarikat) {
            $query->where('pemilikan.no_ic_atau_syarikat', 'like', '%' . $request->no_ic_syarikat . '%');
        }

        // Filter by Negeri
        if ($request->negeri) {
            $query->where('vessels.negeri', $request->negeri);
        }

        // Filter by Daerah
        if ($request->daerah) {
            $query->where('vessels.daerah', $request->daerah);
        }

        // Filter by Pangkalan
        if ($request->pangkalan) {
            $query->where('vessels.pangkalan', $request->pangkalan);
        }

        // Filter by Zon
        if ($request->zon) {
            $query->where('vessels.zon', $request->zon);
        }

        // Filter by Status
        if ($request->status_vesel !== null) {
            $query->where('vessels.status_vesel', $request->status_vesel);
        }

        $vessels = $query->paginate(10);

        return view('app.profile.veselProfile', compact('vessels'));
    }



    /**
     * Show detailed information of the vessel.
     * @param  int  $vesselId The ID of the vessel
     * @return \Illuminate\Http\Response The view of the vessel profile
     */
    public function show($vesselId)
    {
        $user = Auth::user();

        $vessel = Vessel::findOrFail($vesselId);

        $am_vessel = AmVessel::where('no_pendaftaran', $vessel->no_pendaftaran)->firstOrFail();

        // $kulitList = Kulit::where('no_pendaftaran', $vessel->no_pendaftaran)->get();

        $kulitList = Kulit::select('kulit.*', 'muatan.tot_grt')
        ->join('muatan', 'kulit.id', '=', 'muatan.kulit_id')
        ->where('kulit.no_pendaftaran', $vessel->no_pendaftaran)
        ->get();

        $lesen = Lesen::where('no_pendaftaran', $vessel->no_pendaftaran)->get();

        $enjin = Enjin::where('no_pendaftaran', $vessel->no_pendaftaran)->get();

        $peralatan = CmEquipment::where('vessel_id', $vessel->no_pendaftaran)->get();

        $pemilikan = Pemilikan::where('no_pendaftaran', $vessel->no_pendaftaran)->get();

        $kru_aktif = Kru::where('no_pendaftaran', $vessel->no_pendaftaran)
            ->where('status_kru', 1)
            ->get();


        $kesalahan = Kesalahan::where('no_pendaftaran', $vessel->no_pendaftaran)->get();

        // warganegara: 1 = kru tempatan, 2 = penduduk tetap, 3 = kru asing

        $kru_tempatan = Kru::where('no_pendaftaran', $vessel->no_pendaftaran)->where('warganegara', 1)->get();

        $penduduk_tetap = Kru::where('no_pendaftaran', $vessel->no_pendaftaran)->where('warganegara', 2)->get();

        $kru_asing = Kru::where('no_pendaftaran', $vessel->no_pendaftaran)->where('warganegara', 3)->get();

        // $pangkalan = Pangkalan::where('no_pendaftaran', $vessel->no_pendaftaran)->get();
        $pendaftaran_antarabangsa = PendaftaranAntarabangsa::where('vessel_id', $vessel->id)->firstOrFail();
        // $pematuhan = Pematuhan::where('no_pendaftaran', $vessel->no_pendaftaran)->get();

        $pangkalan = collect([$vessel->pangkalanUtama, $vessel->pangkalanTambahan])->filter();
        //$pendaftaran_antarabangsa = $vessel->pendaftaranAntarabangsa ? [$vessel->pendaftaranAntarabangsa] : [];
        // $pematuhan = nd_Lpi_Report::all();

        $pematuhan = Pematuhan::where('no_pendaftaran', $vessel->no_pendaftaran)->get();

        $pendaratan = ListingPendaratan::where('vessel_id', $vessel->id)->get();

        $tab = [
            'am_vessel' => [
                'name' => 'Vesel',
                'description' => 'Maklumat Am Vesel'
            ],
            'lesen' => [
                'name' => 'Lesen',
                'description' => 'Maklumat Lesen'
            ],
            'kulit' => [
                'name' => 'Kulit',
                'description' => 'Maklumat Kulit'
            ],
            'enjin' => [
                'name' => 'Enjin',
                'description' => 'Maklumat Enjin'
            ],
            'peralatan' => [
                'name' => 'Peralatan',
                'description' => 'Maklumat Peralatan'
            ]
        ];

        // Only show these tabs to admin users
        if (Auth::user()->is_admin) {
            $tab['pemilikan'] = [
                'name' => 'Pemilikan',
                'description' => 'Maklumat Pemilikan'
            ];
            $tab['pematuhan'] = [
                'name' => 'Pematuhan',
                'description' => 'Maklumat Pematuhan'
            ];
            $tab['pendaftaran_antarabangsa'] = [
                'name' => 'Pendaftaran Antarabangsa',
                'description' => 'Maklumat Pendaftaran Antarabangsa'
            ];
        }

        // Always visible tabs
        $tab['kru'] = [
            'name' => 'KRU',
            'description' => 'Maklumat KRU'
        ];
        $tab['pangkalan'] = [
            'name' => 'Pangkalan',
            'description' => 'Maklumat Pangkalan'
        ];
        $tab['kesalahan'] = [
            'name' => 'Kesalahan',
            'description' => 'Maklumat Kesalahan'
        ];

        $tab['pendaratan'] = [
            'name' => 'Pendaratan',
            'description' => 'Maklumat Pendaratan'
        ];

        // Nested Tab
        $tabkru = [
            'kru_tempatan' => [
                'name' => 'Warganegara',
                'description' => 'Senarai Warganegara'
            ],
            'penduduk_tetap' => [
                'name' => 'Pemastautin Tetap',
                'description' => 'Senarai Pemastautin Tetap'
            ],
            'kru_asing' => [
                'name' => 'Bukan Warganegara',
                'description' => 'Senarai Bukan Warganegara '
            ],
            'kru_aktif' => [
                'name' => 'KRU Aktif',
                'description' => 'Senarai KRU Aktif'
            ],
        ];

        $tabpematuhan = [
            'vesel' => [
                'name' => 'Vesel',
                'description' => 'Maklumat Am Vesel'
            ],
            'enjin_pematuhan' => [
                'name' => 'Enjin',
                'description' => 'Maklumat Enjin'
            ],
            'peralatan_pelayaran' => [
                'name' => 'Peralatan Pelayaran',
                'description' => 'Maklumat Peralatan Pelayaran'
            ],
            'peralatan_keselamatan' => [
                'name' => 'Peralatan Keselamatan',
                'description' => 'Maklumat Peralatan Keselamatan'
            ],
            'kelengkapan_menangkap_ikan' =>
            [
                'name' => 'Kelengkapan Menangkap Ikan',
                'description' => 'Maklumat Kelengkapan Menangkap Ikan'
            ],
            'dokumen' => [
                'name' => 'Dokumen',
                'description' => 'Maklumat Dokumen'
            ],
           
            

        ];

        $data = compact(
            'user',
            'vessel',
            'tab',
            'tabkru',
            'am_vessel',
            'lesen',
            'kulitList',
            'enjin',
            'peralatan',
            'pemilikan',
            'pematuhan',
            'tabpematuhan',
            'kesalahan',
            'kru_tempatan',
            'penduduk_tetap',
            'kru_asing',
            'kru_aktif',
            'pangkalan',
            'pendaftaran_antarabangsa',
            'pendaratan'
        );

        return view('app.profile.veselTabLayout', $data);
    }
    public function kulitTable($vesselId, $kulitId)
    {
        $user = Auth::user();
        // Fetch the kulit record by ID
        $kulit = Kulit::findOrFail($kulitId);

        if (!$kulit) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        $muatan = Muatan::where('kulit_id', $kulitId)->first();

        //25042025 Arifah
        $vessel = Vessel::where('id',$vesselId)->first();

        return view('app.profile.tab.kulittable', compact('kulit', 'muatan', 'user', 'vessel'));
    }

    public function patuhTable($vesselId, $patuhId)
    {
        $vessel = Vessel::findOrFail($vesselId);
        
        // $pematuhan = Pematuhan::where('no_pendaftaran', $vessel->no_pendaftaran)->get();
        $pematuhan = Pematuhan::query()
            ->leftJoin('enjin', 'pematuhan.no_pendaftaran', '=', 'enjin.no_pendaftaran')
            ->where('pematuhan.no_pendaftaran', $vessel->no_pendaftaran)
            ->select('pematuhan.*', 'enjin.*')
            ->get();

        $enjin = Enjin::where('no_pendaftaran', $vessel->no_pendaftaran);
        
        $tabpematuhan = [
            'vesel' => [
                'name' => 'Vesel',
                'description' => 'Maklumat Am Vesel'
            ],
            'enjin_pematuhan' => [
                'name' => 'Enjin',
                'description' => 'Maklumat Enjin'
            ],
            'peralatan_pelayaran' => [
                'name' => 'Peralatan Pelayaran',
                'description' => 'Maklumat Peralatan Pelayaran'
            ],
            'peralatan_keselamatan' => [
                'name' => 'Peralatan Keselamatan',
                'description' => 'Maklumat Peralatan Keselamatan'
            ],
            'kelengkapan_menangkap_ikan' =>
            [
                'name' => 'Kelengkapan Menangkap Ikan',
                'description' => 'Maklumat Kelengkapan Menangkap Ikan'
            ],
            'dokumen' => [
                'name' => 'Dokumen',
                'description' => 'Maklumat Dokumen'
            ],
           
        ];


        return view('app.profile.tab.pematuhandetail', compact('tabpematuhan', 'pematuhan', 'enjin'));
    }
    
    public function enjinImage($vesselId, $enjinId)
    {
        $user = Auth::user();
        // Fetch the enjin record by ID
        $enjin = Enjin::findOrFail($enjinId);

        if (!$enjin) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        // Pass the data to the view
        return view('app.profile.tab.enjindetail', compact('enjin', 'user'));
    }

    


    public function formpendaratan($vesselId)
    {
        $vessel = Vessel::findOrFail($vesselId);

        return view('app.profile.formaddpendaratan', compact('vessel')	
           
		);
    }

    public function storePendaratan(Request $request)
    {
        
        //dd($request->all()); 

        $request->validate([
            'pelayaran_no' => 'required|string',
            'bulan' => 'required|string',
            'jumlah_hari_di_laut' => 'required|numeric',
            'tarikh_berlepas' => 'required|date',
            'tarikh_tiba' => 'required|date',
            'purata_masa_memukat' => 'required|string',
            'dokumen' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);


        $dokumenPath = null;
        $dokumenType = null;
        $dokumenName = null;

        if ($request->hasFile('dokumen')) {
            $file = $request->file('dokumen'); // <-- betulkan di sini
            $dokumenPath = $file->store('dokumen_pendaratan', 'public');
            $dokumenType = $file->getClientMimeType(); // contoh: image/jpeg atau application/pdf
            $dokumenName = $file->getClientOriginalName(); // contoh: laporan_mingguan.pdf
        }

        $vesselId = $request->vessel_id;

        $vessel = Vessel::findOrFail($vesselId);

        ListingPendaratan::create([
            'pelayaran_no' => $request->pelayaran_no,
            'vessel_id' => $request->vessel_id,
            'bulan' => $request->bulan,
            'jumlah_hari_di_laut' => $request->jumlah_hari_di_laut,
            'tarikh_masa_berlepas' => $request->tarikh_berlepas,
            'tarikh_masa_tiba' => $request->tarikh_tiba,
            'purata_masa_memukat' => $request->purata_masa_memukat,
            'dokumen_nama' => $dokumenName,
            'dokumen' => $dokumenPath,
            'dokumen_type' => $dokumenType, 
        ]);

        $tab['pendaratan'] = [
            'name' => 'Pendaratan',
            'description' => 'Maklumat Pendaratan'
        ];

        // DB::table('listing_pendaratan')->insert([
        //     'pelayaran_no' => $request->pelayaran_no,
        //     'vessel_id' => $request->vessel_id,
        //     'bulan' => $request->bulan,
        //     'jumlah_hari_di_laut' => $request->jumlah_hari_di_laut,
        //     'tarikh_berlepas' => $request->tarikh_berlepas,
        //     'tarikh_tiba' => $request->tarikh_tiba,
        //     'purata_masa_memukat' => $request->purata_masa_memukat,
        //     'dokumen' => $dokumenPath,
        //     'dokumen_nama' => $dokumenName,
        //     'dokumen_type' => $dokumenType,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        $pendaratan = ListingPendaratan::where('vessel_id',  $vesselId)->get();

        return redirect()->route('profile.pendaratan.tab.show', ['id' => $vesselId , 'tab' => 'pendaratan'])->with('success', 'Maklumat pendaratan berjaya disimpan.');
    }

    public function pilihCara($vesselId)
    {
        $vessel = Vessel::findOrFail($vesselId);

        return view('app.profile.pilih-cara' , compact('vessel'));
    }

    

    public function formubahsuai($vesselId)
    {
        $vessel = Vessel::findOrFail($vesselId);

        return view('app.profile.formubahsuai', compact('vessel')	
           
		);
    }
}
