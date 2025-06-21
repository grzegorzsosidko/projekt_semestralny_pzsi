<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Document;
use App\Models\Faq;
use App\Models\User;
use App\Models\Gallery;

class PageController extends Controller
{
    public function gallery(): View
    {
        $galleries = Gallery::where('is_hidden', false)
            ->with(['user', 'images'])
            ->latest()
            ->get();
        return view('pages.gallery', compact('galleries'));
    }

    public function knowledge(): View
    {
        $faqs = Faq::where('is_hidden', false)->with('user')->latest()->get();
        return view('pages.knowledge', compact('faqs'));
    }

    public function documents(): View
    {
        $documents = Document::where('status', 'published')
            ->with(['category', 'user', 'files'])
            ->latest()
            ->get();
        return view('pages.documents', compact('documents'));
    }

    public function phoneBook(): View
    {
        $users = User::where(function ($query) {
            $query->whereNotNull('email')->orWhereNotNull('phone_number');
        })
            ->whereNull('blocked_at')
            ->orderBy('name', 'asc')
            ->get();
        return view('pages.phonebook', compact('users'));
    }

    
    public function exportPhoneBookCsv()
    {
        $users = User::where(function ($query) {
            $query->whereNotNull('email')->orWhereNotNull('phone_number');
        })
            ->whereNull('blocked_at')
            ->get();

        $fileName = 'kontakty_intranet_' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=$fileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        // Nagłówki wymagane przez Google Contacts do poprawnego importu
        $columns = ['Name', 'Given Name', 'Additional Name', 'Family Name', 'Yomi Name', 'Given Name Yomi', 'Additional Name Yomi', 'Family Name Yomi', 'Name Prefix', 'Name Suffix', 'Initials', 'Nickname', 'Short Name', 'Maiden Name', 'Birthday', 'Gender', 'Location', 'Billing Information', 'Directory Server', 'Mileage', 'Occupation', 'Hobby', 'Sensitivity', 'Priority', 'Subject', 'Notes', 'Language', 'Photo', 'Group Membership', 'E-mail 1 - Type', 'E-mail 1 - Value', 'Phone 1 - Type', 'Phone 1 - Value', 'Organization 1 - Name', 'Organization 1 - Title'];

        $callback = function () use ($users, $columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xef) . chr(0xbb) . chr(0xbf)); // Dodaj BOM dla poprawnego kodowania UTF-8 w Excelu
            fputcsv($file, $columns);

            foreach ($users as $user) {
                $row = [];
                $row['Name'] = $user->name;
                // Pozostałe pola imion można by próbować wyodrębnić, ale dla prostoty zostawiamy puste
                $row['Given Name'] = '';
                $row['Family Name'] = '';

                $row['Group Membership'] = 'Intranet'; // Można dodać kontakty do konkretnej grupy

                $row['E-mail 1 - Type'] = 'Work';
                $row['E-mail 1 - Value'] = $user->email;

                $row['Phone 1 - Type'] = 'Work';
                $row['Phone 1 - Value'] = $user->phone_number;

                $row['Organization 1 - Name'] = 'Polski Holding Rybny'; // Można ustawić na stałe
                $row['Organization 1 - Title'] = $user->title;

                // Wypełniamy pustymi wartościami, aby zgadzała się liczba kolumn
                $csvRow = [];
                foreach ($columns as $column) {
                    $csvRow[] = $row[$column] ?? '';
                }
                fputcsv($file, $csvRow);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
