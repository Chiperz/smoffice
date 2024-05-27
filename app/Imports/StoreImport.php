<?php

namespace App\Imports;

use App\Models\Customer;
use App\Models\Branch;
use App\Models\User;
use App\Models\Owner;
use App\Models\Area;
use App\Models\SubArea;

use Illuminate\Support\Facades\Auth;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class StoreImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    
    public function collection(Collection $rows)
    {
        foreach ($rows as $row ) 
        {   
            // return dd($row);
            $area;$subArea;
            if(empty($row['Kode Toko'])){
                $branch = Branch::where('code', $row['Kode Cabang'])->first();
                $user = User::where('username', $row['Username'])->first();
                // $codeBranch = Branch::where('code', $row['Kode Cabang'])->first()->code;
                $codeBranch = $row['Kode Cabang'];
                $lastCodeCustomer = Customer::orderBy('code', 'desc')->where('code', 'LIKE', '%'.$codeBranch.'%')->first();

                if(empty($lastCodeCustomer)){
                    $row['Kode Toko'] = $codeBranch.'001';
                }else{
                    $lastDigit = intval(substr($lastCodeCustomer->code,3));
                    if($lastDigit < 10){
                        if($lastDigit == 0){
                            $generator = '001';    
                        }else{
                            $generator = '00'.$lastDigit+1;
                        }
                    }elseif($lastDigit >= 10 && $lastDigit <100){
                        $generator = '0'.$lastDigit+1;
                    }else{
                        $generator = $lastDigit+1;
                    }
                    $row['Kode Toko'] = $codeBranch.$generator;
                }

                if(!empty($row['Area'])){
                    $area = Area::where('name', 'LIKE', '%'.strtoupper($row['Area']).'%')->first();

                    if(empty($area)){
                        $area = Area::create([
                            'branch_id' => $branch->id,
                            'name' => strtoupper($row['Area'])
                        ]);
                        $area = Area::latest()->first();
                    }

                    if(!empty($row['Sub Area'])){
                        $subArea = SubArea::where('name', 'LIKE', '%'.strtoupper($row['Sub Area']).'%')->first();
    
                        if(empty($subArea)){
                            $subArea = SubArea::create([
                                'branch_id' => $branch->id,
                                'area_id' => $area->id,
                                'name' => strtoupper($row['Sub Area'])
                            ]);
                            $subArea = SubArea::latest()->first();
                        }
                    }

                }

                Customer::create([
                    'code' => str_replace('/',' - ',$row['Kode Toko']),
                    'name' => str_replace('/',' - ',$row['Nama Toko']),
                    'phone' => $row['No Telepon Toko'],
                    'address' => $row['Alamat Toko'],
                    'LA' => $row['Latitude'],
                    'LO' => $row['Longitude'],
                    'area_id' => empty($area) ? '' : $area->id,
                    'sub_area_id' => empty($subArea) ? '' : $subArea->id,
                    'status_registration' => empty($row['Registrasi']) ? 'N' : $row['Registrasi'],
                    'type' => 'S',
                    'banner' => empty($row['Spanduk']) ? 0 : $row['Spanduk'],
                    'branch_id' => empty($branch) ? NULL : $branch->id,
                    'user_id' => empty($user) ? NULL : $user->id,
                    'status' => empty($row['Status']) ? 1 : $row['Status'],
                    'created_by' => Auth::user()->id,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }else{
                $customer = Customer::where('code', $row['Kode Toko'])->first();
                $branch = Branch::where('code', $row['Kode Cabang'])->first();
                $user = User::where('username', $row['Username'])->first();

                if(!empty($row['Area'])){
                    $area = Area::where('name', 'LIKE', '%'.strtoupper($row['Area']).'%')->first();

                    if(empty($area)){
                        $area = Area::create([
                            'branch_id' => $branch->id,
                            'name' => strtoupper($row['Area'])
                        ]);
                        $area = Area::latest()->first();
                    }

                    if(!empty($row['Sub Area'])){
                        $subArea = SubArea::where('name', 'LIKE', '%'.strtoupper($row['Sub Area']).'%')->first();
    
                        if(empty($subArea)){
                            $subArea = SubArea::create([
                                'branch_id' => $branch->id,
                                'area_id' => $area->id,
                                'name' => strtoupper($row['Sub Area'])
                            ]);
                            $subArea = SubArea::latest()->first();
                        }
                    }
                    
                }

                if($customer){
                    if(!empty($row['Area'])){
                        $area = Area::where('name', 'LIKE', '%'.strtoupper($row['Area']).'%')->first();
    
                        if(empty($area)){
                            $area = Area::create([
                                'branch_id' => $branch->id,
                                'name' => strtoupper($row['Area'])
                            ]);
                            $area = Area::latest()->first();
                        }
    
                        if(!empty($row['Sub Area'])){
                            $subArea = SubArea::where('name', 'LIKE', '%'.strtoupper($row['Sub Area']).'%')->first();
        
                            if(empty($subArea)){
                                $subArea = SubArea::create([
                                    'branch_id' => $branch->id,
                                    'area_id' => $area->id,
                                    'name' => strtoupper($row['Sub Area'])
                                ]);
                                $subArea = SubArea::latest()->first();
                            }
                        }
                        
                    }
                    $customer->update([
                        'name' => str_replace('/',' - ',$row['Nama Toko']),
                        'phone' => $row['No Telepon Toko'],
                        'address' => $row['Alamat Toko'],
                        'LA' => $row['Latitude'],
                        'LO' => $row['Longitude'],
                        'area_id' => empty($area) ? 0 : $area->id,
                        'sub_area_id' => empty($subArea) ? 0 : $subArea->id,
                        'status_registration' => empty($row['Registrasi']) ? 'N' : $row['Registrasi'],
                        'type' => 'S',
                        'banner' => empty($row['Spanduk']) ? 0 : $row['Spanduk'],
                        'branch_id' => empty($branch) ? NULL : $branch->id,
                        'user_id' => empty($user) ? NULL : $user->id,
                        'status' => empty($row['Status']) ? 1 : $row['Status'],
                        'updated_by' => Auth::user()->id,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }else{
                    if(!empty($row['Area'])){
                        $area = Area::where('name', 'LIKE', '%'.strtoupper($row['Area']).'%')->first();
    
                        if(empty($area)){
                            $area = Area::create([
                                'branch_id' => $branch->id,
                                'name' => strtoupper($row['Area'])
                            ]);
                            $area = Area::latest()->first();
                        }
    
                        if(!empty($row['Sub Area'])){
                            $subArea = SubArea::where('name', 'LIKE', '%'.strtoupper($row['Sub Area']).'%')->first();
        
                            if(empty($subArea)){
                                $subArea = SubArea::create([
                                    'branch_id' => $branch->id,
                                    'area_id' => $area->id,
                                    'name' => strtoupper($row['Sub Area'])
                                ]);
                                $subArea = SubArea::latest()->first();
                            }
                        }
                        
                    }
                    Customer::create([
                        'code' => str_replace('/'.' - ',$row['Kode Toko']),
                        'name' => str_replace('/',' - ',$row['Nama Toko']),
                        'phone' => $row['No Telepon Toko'],
                        'address' => $row['Alamat Toko'],
                        'LA' => $row['Latitude'],
                        'LO' => $row['Longitude'],
                        'area_id' => empty($area) ? '' : $area->id,
                        'sub_area_id' => empty($subArea) ? '' : $subArea->id,
                        'status_registration' => empty($row['Registrasi']) ? 'N' : $row['Registrasi'],
                        'type' => 'S',
                        'banner' => empty($row['Spanduk']) ? 0 : $row['Spanduk'],
                        'branch_id' => empty($branch) ? NULL : $branch->id,
                        'user_id' => empty($user) ? NULL : $user->id,
                        'status' => empty($row['Status']) ? 1 : $row['Status'],
                        'created_by' => Auth::user()->id,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }
    }
}
