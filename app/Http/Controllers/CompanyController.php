<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Fetching companies and adding DT_RowIndex
            $companies = Company::select(['id', 'name', 'email', 'website', 'logo']);

            return DataTables::of($companies)
                ->addIndexColumn() // This line adds the DT_RowIndex
                ->addColumn('logo', function ($row) {
                    return $row->logo; // Return the logo path
                })
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-sm btn-info view-btn" data-id="'.$row->id.'">View</button>
                            <button class="btn btn-sm btn-warning edit-btn" data-id="'.$row->id.'">Edit</button>
                            <button class="btn btn-sm btn-danger delete-btn" data-url="'.route('companies.destroy', $row->id).'">Delete</button>';
                })
                ->make(true);
        }
        return view('companies.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $company = new Company();
        $company->name = $request->name;
        $company->email = $request->email;
        $company->website = $request->website;

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $company->logo = $path;
        }

        $company->save();

        return view('companies.index');
    }

    public function show($id)
    {
        $company = Company::findOrFail($id);
        return response()->json($company);
    }

    public function update(Request $request, $id)
    {
        // Validate incoming request
        $request->validate([
            'name' => 'required',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Find the company by ID
        $company = Company::findOrFail($id);
        $company->name = $request->name;
        $company->email = $request->email;
        $company->website = $request->website;

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }
            // Store new logo
            $company->logo = $request->file('logo')->store('logos', 'public');
        }

        $company->save();

        return redirect()->route('companies.index')->with('success', 'Company updated successfully.');
    }


    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        // Delete logo from storage if exists
        if ($company->logo) {
            \Storage::disk('public')->delete($company->logo);
        }
        $company->delete();

        return view('companies.index');
    }
}
