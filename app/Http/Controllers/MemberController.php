<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\User;
use App\Mail\MemberCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Picqer\Barcode\BarcodeGeneratorPNG;

class MemberController extends Controller
{
    private $title = 'Member';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = str($this->title)->plural();
        return view('pages.member.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title'] = 'New ' . $this->title;
        return view('pages.member.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    { {
            try {
                DB::beginTransaction();
                $member = new User();
                $member->name = $request->name;
                $member->email = $request->email;
                $member->email_verified_at = now();
                $member->password = fake()->sentence();
                $member->save();
                $member->assignRole(User::ROLE_ANGGOTA);

                $card = new Card();
                $card->user_id = $member->getKey();
                $card->number = str($member->getKey())->padLeft(5, '0');
                $card->start_date = now();
                $card->end_date = now()->addYear();
                $card->save();
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                Log::error(
                    $th->getMessage(),
                    [
                        'action' => 'Store member',
                        'data' => $request->all()
                    ]
                );
                return to_route('members.index')->withToastError($th->getMessage());
            }

            return to_route('members.index')->withToastSuccess($this->title . ' created successfully!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $member)
    {
        return self::edit($member);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $member)
    {
        $data['title'] = 'Edit ' . $this->title;
        $data['member'] = $member;
        return view('pages.member.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $member)
    { {
            DB::beginTransaction();
            try {
                $member->name = $request->name;
                $member->email = $request->email;
                $member->save();
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                Log::error(
                    $th->getMessage(),
                    [
                        'action' => 'Delete member',
                        'data' => $member
                    ]
                );
                return to_route('members.index')->withToastError($th->getMessage());
            }
            return to_route('members.index')->withToastSuccess($this->title . ' updated successfully!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $member)
    {
        try {
            DB::beginTransaction();
            $member->delete();
            DB::commit();

            return response()->json([
                'msg' => $this->title . ' deleted successfully!'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error(
                $th->getMessage(),
                [
                    'action' => 'Delete member',
                    'data' => $member
                ]
            );

            return response()->json([
                'msg' => $th->getMessage()
            ]);
        }
    }

    /**
     * Send member card to the member's email address
     */
    public function sendMemberCard(User $member)
    {
        try {
            $generatorPNG = new BarcodeGeneratorPNG();
            $barcodeImage = "data:image/png;base64," . base64_encode($generatorPNG->getBarcode($member->card->number, $generatorPNG::TYPE_CODE_128));
            // render ID Card HTML view from a blade template
            $pdfHtml = view('pdf.member.card', [
                'memberName' => $member->name,
                'cardMemberNo' => $member->card->number,
                'cardMemberName' => $member->name,
                'cardMemberEmail' => $member->email,
                'cardMemberExpired' => date('j F, Y', strtotime($member->card->end_date)),
                'barcodeImage' => $barcodeImage
            ])->render();

            // generate pdf file for member card based on card data
            $pdf = app('dompdf.wrapper');
            $pdf->loadHTML($pdfHtml);

            // then send the email with the attachment to the member's email
            Mail::to($member)->send(new MemberCard($member, $pdf->output()));
        } catch (\Throwable $th) {
            Log::error(
                $th->getMessage(),
                [
                    'action' => 'Send Member card',
                    'data' => $member
                ]
            );
            return to_route('members.index')->withToastError($th->getMessage());
        }

        return to_route('members.index')->withToastSuccess('Member card has been successfully sent!');
    }
}
