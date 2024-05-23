<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ModelHasRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        Schema::disableForeignKeyConstraints();
        \DB::table('model_has_roles')->delete();

        \DB::table('model_has_roles')->insert(array (
            0 =>
            array (
                'role_id' => 1,
                'model_type' => 'App\\Models\\User',
                'model_id' => 1,
            ),
            1 =>
            array (
                'role_id' => 1,
                'model_type' => 'App\\Models\\User',
                'model_id' => 2,
            ),
            2 =>
            array (
                'role_id' => 1,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            3 =>
            array (
                'role_id' => 1,
                'model_type' => 'App\\Models\\User',
                'model_id' => 4,
            ),
            4 =>
            array (
                'role_id' => 1,
                'model_type' => 'App\\Models\\User',
                'model_id' => 5,
            ),
            5 =>
            array (
                'role_id' => 1,
                'model_type' => 'App\\Models\\User',
                'model_id' => 6,
            ),
            6 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 8,
            ),
            7 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 9,
            ),
            8 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 10,
            ),
            9 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 11,
            ),
            10 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 12,
            ),
            11 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 13,
            ),
            12 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 14,
            ),
            13 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 15,
            ),
            14 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 16,
            ),
            15 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 17,
            ),
            16 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 18,
            ),
            17 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 19,
            ),
            18 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 20,
            ),
            19 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 21,
            ),
            20 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 22,
            ),
            21 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 23,
            ),
            22 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 24,
            ),
            23 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 25,
            ),
            24 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 26,
            ),
            25 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 27,
            ),
            26 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 28,
            ),
            27 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 29,
            ),
            28 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 30,
            ),
            29 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 31,
            ),
            30 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 32,
            ),
            31 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 33,
            ),
            32 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 34,
            ),
            33 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 35,
            ),
            34 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 36,
            ),
            35 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 37,
            ),
            36 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 38,
            ),
            37 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 39,
            ),
            38 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 40,
            ),
            39 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 41,
            ),
            40 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 42,
            ),
            41 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 43,
            ),
            42 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 44,
            ),
            43 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 45,
            ),
            44 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 46,
            ),
            45 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 47,
            ),
            46 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 48,
            ),
            47 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 49,
            ),
            48 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 50,
            ),
            49 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 51,
            ),
            50 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 52,
            ),
            51 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 53,
            ),
            52 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 54,
            ),
            53 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 55,
            ),
            54 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 56,
            ),
            55 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 57,
            ),
            56 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 58,
            ),
            57 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 59,
            ),
            58 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 60,
            ),
            59 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 61,
            ),
            60 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 62,
            ),
            61 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 63,
            ),
            62 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 64,
            ),
            63 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 65,
            ),
            64 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 66,
            ),
            65 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 67,
            ),
            66 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 68,
            ),
            67 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 69,
            ),
            68 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 70,
            ),
            69 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 71,
            ),
            70 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 72,
            ),
            71 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 73,
            ),
            72 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 74,
            ),
            73 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 75,
            ),
            74 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 76,
            ),
            75 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 77,
            ),
            76 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 78,
            ),
            77 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 79,
            ),
            78 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 80,
            ),
            79 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 81,
            ),
            80 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 82,
            ),
            81 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 83,
            ),
            82 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 84,
            ),
            83 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 85,
            ),
            84 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 86,
            ),
            85 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 87,
            ),
            86 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 88,
            ),
            87 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 89,
            ),
            88 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 90,
            ),
            89 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 91,
            ),
            90 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 92,
            ),
            91 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 93,
            ),
            92 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 94,
            ),
            93 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 95,
            ),
            94 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 96,
            ),
            95 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 97,
            ),
            96 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 98,
            ),
            97 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 99,
            ),
            98 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 100,
            ),
            99 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 101,
            ),
            100 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 102,
            ),
            101 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 103,
            ),
            102 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 104,
            ),
            103 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 105,
            ),
            104 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 106,
            ),
            105 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 107,
            ),
            106 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 108,
            ),
            107 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 109,
            ),
            108 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 110,
            ),
            109 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 111,
            ),
            110 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 112,
            ),
            111 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 113,
            ),
            112 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 114,
            ),
            113 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 115,
            ),
            114 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 116,
            ),
            115 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 117,
            ),
            116 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 118,
            ),
            117 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 119,
            ),
            118 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 120,
            ),
            119 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 121,
            ),
            120 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 122,
            ),
            121 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 123,
            ),
            122 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 124,
            ),
            123 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 125,
            ),
            124 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 126,
            ),
            125 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 127,
            ),
            126 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 128,
            ),
            127 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 129,
            ),
            128 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 130,
            ),
            129 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 131,
            ),
            130 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 132,
            ),
            131 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 133,
            ),
            132 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 134,
            ),
            133 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 135,
            ),
            134 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 136,
            ),
            135 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 137,
            ),
            136 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 138,
            ),
            137 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 139,
            ),
            138 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 140,
            ),
            139 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 141,
            ),
            140 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 142,
            ),
            141 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 143,
            ),
            142 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 144,
            ),
            143 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 145,
            ),
            144 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 146,
            ),
            145 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 147,
            ),
            146 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 148,
            ),
            147 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 149,
            ),
            148 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 150,
            ),
            149 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 151,
            ),
            150 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 152,
            ),
            151 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 153,
            ),
            152 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 154,
            ),
            153 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 155,
            ),
            154 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 156,
            ),
            155 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 157,
            ),
            156 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 158,
            ),
            157 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 159,
            ),
            158 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 160,
            ),
            159 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 161,
            ),
            160 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 162,
            ),
            161 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 163,
            ),
            162 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 164,
            ),
            163 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 165,
            ),
            164 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 166,
            ),
            165 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 167,
            ),
            166 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 168,
            ),
            167 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 169,
            ),
            168 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 170,
            ),
            169 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 171,
            ),
            170 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 172,
            ),
            171 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 173,
            ),
            172 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 174,
            ),
            173 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 175,
            ),
            174 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 176,
            ),
            175 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 177,
            ),
            176 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 178,
            ),
            177 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 179,
            ),
            178 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 180,
            ),
            179 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 181,
            ),
            180 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 182,
            ),
            181 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 183,
            ),
            182 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 184,
            ),
            183 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 185,
            ),
            184 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 186,
            ),
            185 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 187,
            ),
            186 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 188,
            ),
            187 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 189,
            ),
            188 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 190,
            ),
            189 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 191,
            ),
            190 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 192,
            ),
            191 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 193,
            ),
            192 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 194,
            ),
            193 =>
            array (
                'role_id' => 2,
                'model_type' => 'App\\Models\\User',
                'model_id' => 195,
            ),
            194 =>
            array (
                'role_id' => 7,
                'model_type' => 'App\\Models\\User',
                'model_id' => 7,
            ),
        ));

        Schema::enableForeignKeyConstraints();
    }
}
