<?php

namespace Database\Seeders;

use App\Models\Form;
use App\Models\Input;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InputSeeder extends Seeder
{

    public function run()
    {
        Form::create(
            [
                'id'=>'1',
                'name' => 'Zorunlu Staj ve Sigorta Belgesi',
                'status' => '1',
            ]);
        //Zorunlu Staj ve Sigorta Belgesi
        Input::create(
            [
                'name' => 'form_create_date',
                'form_id' => '1',
            ]);
        Input::create(
            [
                'name' => 'student_no',
                'form_id' => '1',
            ]);
        Input::create(
            [
                'name' => 'student_name',// soyad eklensinmi?
                'form_id' => '1',
            ]);


        Form::create(
            [
                'id'=>'2',
                'name' => 'Staj Başvuru Dilekçesi ve Kabul Formu',
                'status' => '1',
            ]);
            //Staj Başvuru Dilekçesi ve Kabul Formu
        Input::create(
            [
                'name' => 'student_part_write_date',// öğrencinin belgeyi imzaladağı tarih
                'form_id' => '2',
            ]);
        Input::create(
            [
                'name' => 'company_name',
                'form_id' => '2',
            ]);
        Input::create(
            [
                'name' => 'department',// hangi bölüm
                'form_id' => '2',
            ]);
        Input::create(
            [
                'name' => 'grade',// kaçıncı sınıf
                'form_id' => '2',
            ]);
        Input::create(
            [
                'name' => 'student_no',
                'form_id' => '2',
            ]);
        Input::create(
            [
                'name' => 'part',// 1. stajmı 2. stajmı
                'form_id' => '2',
            ]);
        Input::create(
            [
                'name' => 'address',
                'form_id' => '2',
            ]);
        Input::create(
            [
                'name' => 'phone_number',
                'form_id' => '2',
            ]);
        Input::create(
            [
                'name' => 'email',
                'form_id' => '2',
            ]);
        Input::create(
            [
                'name' => 'company_part_write_date',// şirketin belgeyi imzaladağı tarih
                'form_id' => '2',
            ]);
        Input::create(
            [
                'name' => 'department',// hangi bölüm
                'form_id' => '2',
            ]);
        Input::create(
            [
                'name' => 'student_no',
                'form_id' => '2',
            ]);
        Input::create(
            [
                'name' => 'student_name',
                'form_id' => '2',
            ]);
        Input::create(
            [
                'name' => 'Internship_start_date',//staj başlama tarihi
                'form_id' => '2',
            ]);
        Input::create(
            [
                'name' => 'Internship_end_date',
                'form_id' => '2',
            ]);
        Input::create(
            [
                'name' => 'student_tc_no',//öğrenci tc no
                'form_id' => '2',
            ]);
        Input::create(
            [
                'name' => 'student_birth_date',
                'form_id' => '2',
            ]);

        //firma kurum bilgileri
        Input::create(
            [
                'name' => 'business_segment',// faaliyet alanı
                'form_id' => '2',
            ]);
        Input::create(
            [
                'name' => 'workers',// çalışan sayısı
                'form_id' => '2',
            ]);
        Input::create(
            [
                'name' => 'engineers',// mühendis sayısı
                'form_id' => '2',
            ]);
        Input::create(
            [
                'name' => 'software_engineers',// yazılım pc muhendisi sayısı
                'form_id' => '2',
            ]);
        Input::create(
            [
                'name' => 'address',
                'form_id' => '2',
            ]);
        Input::create(
            [
                'name' => 'phone_number',
                'form_id' => '2',
            ]);
        Input::create(
            [
                'name' => 'fax', // faks
                'form_id' => '2',
            ]);
        Input::create(
            [
                'name' => 'company_email',
                'form_id' => '2',
            ]);
        Input::create(
            [
                'name' => 'company_Iban', // şirket iban nosu
                'form_id' => '2',
            ]);


        Form::create(
            [
                'id'=>'3',
                'name' => 'Staj Ücretlerine İşsizlik Fonu Katkısı Bilgi ve Onay Formu',
                'status' => '1',
            ]);
            //Staj Ücretlerine İşsizlik Fonu Katkısı Bilgi ve Onay Formu
        Input::create(
        [
            'name' => 'Internship_start_date', // staj başlama tarihi
            'form_id' => '3',
        ]);
        Input::create(
        [
            'name' => 'Internship_end_date', // staj bitiş tarihi
            'form_id' => '3',
        ]);
        Input::create(
        [
            'name' => 'company_tax_no', // işletme vergi no
            'form_id' => '3',
        ]);
        Input::create(
        [
            'name' => 'company_name',
            'form_id' => '3',
        ]);
       Input::create(
        [
            'name' => 'personal_number', // personel sayısı
            'form_id' => '3',
        ]);
       Input::create(
           [
               'name' => 'software_engineers', // muhendis sayısı
               'form_id' => '3',
           ]);
       Input::create(
           [
               'name' => 'company_phone_number', // telefon yada faks
               'form_id' => '3',
           ]);
       Input::create(
           [
               'name' => 'company_address',
               'form_id' => '3',
           ]);
       Input::create(
           [
               'name' => 'branch_bank', //İŞLETME/KURUM/KURULUŞ BANKA /ŞUBESİ ADI
               'form_id' => '3'
           ]);
       Input::create(
           [
               'name' => 'company_Iban', // şirket iban no
               'form_id' => '3',
           ]);
       Input::create(
           [
               'name' => 'Internship_salary', //öğrencinin alacağı maaş
               'form_id' => '3',
           ]);
       Input::create(
           [
               'name' => 'Internship_days', // staj günü sayısı
               'form_id' => '3',
           ]);
         Input::create(
             [
                 'name' => 'student_part_write_date',// öğrencinin belgeyi imzaladağı tarih
                 'form_id' => '3',
             ]);
         Input::create(
             [
                 'name' => 'company_part_write_date',// şirketin belgeyi imzaladağı tarih
                 'form_id' => '3',
             ]);
        Form::create(
            [
                'id'=>'4',
                'name' => 'Staj Değerlendirme Formu',
                'status' => '1',
            ]);
         //Staj Değerlendirme Formu
        Input::create(
            [
                'name' => 'part',// 1. stajmı 2. stajmı
                'form_id' => '4',
            ]);
        Input::create(
            [
                'name' => 'company_name_address',// işyeri adı ve adresi
                'form_id' => '4',
            ]);
        Input::create(
            [
                'name' => 'part',// 1. stajmı 2. stajmı
                'form_id' => '4',
            ]);

        Input::create(
            [
                'name' => 'continuity',// işe devamı
                'form_id' => '4',
             ]);
        Input::create(
            [
                'name' => 'work_effort',// çalışma ve gayreti
                'form_id' => '4',
            ]);
        Input::create(
            [
                'name' => 'behavior',// Çalışma Ortamındaki Davranış ve Tutumu
                'form_id' => '4',
            ]);
        Input::create(
            [
                'name' => 'knowledge_level',//Temel Mühendislik Bilgisi Düzeyi
                'form_id' => '4',
            ]);
        Input::create(
            [
                'name' => 'individual_work',//Bireysel Çalışmalardaki Etkinliği ve Başarısı
                'form_id' => '4',
            ]);
        Input::create(
            [
                'name' => 'team_work',// Takım Çalışmasında Uyumluluğu ve Başarımı
                'form_id' => '4',
            ]);
        Input::create(
            [
                'name' => 'self_expression',// Kendini Sözlü İfade Edebilme Yeteneği
                'form_id' => '4',
            ]);
        Input::create(
            [
                'name' => 'other_thoughts',// diğer düşünceler
                'form_id' => '4',
            ]);
        Input::create(
            [
                'name' => 'Internship_in_charge',// staj sorumlusu
                'form_id' => '4',
            ]);
        Input::create(
            [
                'name' => 'company_executive',// Staj Yaptıran İşyeri Yetkilisi
                'form_id' => '4',
            ]);
    }
}
