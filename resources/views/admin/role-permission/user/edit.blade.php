


@extends('admin.dashboard')

@section('admin')

<style>
    .form-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 5px;
        margin-top:50px;
    }
    .form-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e0e0e0;
    }
    .form-group {
        display: flex;
        margin-bottom: 15px;
        align-items: center;
    }
    .form-label {
        width: 200px;
        text-align: right;
        padding-right: 20px;
        font-weight: bold;
    }
    .form-input {
        flex: 1;
    }
    .form-input input, .form-input select {
        width: 100%;
        padding: 5px;
        border: 1px solid #272626;
        border-radius: 3px;
    }
    .required::after {
        content: '(必須)';
        color: red;
        font-size: 0.8em;
        margin-left: 5px;
    }
    .input-hint {
        font-size: 0.8em;
        color: #666;
        margin-left: 10px;
    }
    .submit-button {
        background-color: #ff7f50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        float: right;
        margin-top: 20px;
    }
</style>

<div class="form-container mb-2">
    <h1 class="text-xl font-medium mb-6">
        社員管理

     </h1>
    <h2 class="form-title">基本情報編集</h2>
    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">無効データ入力</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.role-permission.user.update', $user->id) }}" method="POST">
        @csrf

        @method('PUT')
        <div class="form-group">
            <label for="corp_id" class="form-label required">会社</label>
            <div class="form-input">
                <select name="corp_id" id="corp_id">
                    <option value="">会社選択</option>
                    @foreach ($corps as $corp)
                    <option value="{{ $corp->id }}" {{ old('corp_id', $user->corp_id) == $corp->id ? 'selected' : '' }}>
                        {{ $corp->corp_name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="office_id" class="form-label required">営業所</label>
            <div class="form-input">
                <select name="office_id" id="office_id" required onchange="updateDivisions()">
                    <option value="">営業所選択</option>
                    @foreach ($offices as $office)
                    <option value="{{ $office->id }}" {{ old('office_id', $user->office_id) == $office->id ? 'selected' : '' }}>
                        {{ $office->office_name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="division_id" class="form-label required">所属</label>
            <div class="form-input">
                <select name="division_id" id="division_id" required>
                    <option value="">所属選択</option>
                    @foreach ($divisions as $division)
                    <option value="{{ $division->id }}" {{ old('division_id', $user->division_id) == $division->id ? 'selected' : '' }}>
                        {{ $division->name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>


        <div class="form-group">
            <label for="employer_id" class="form-label required">社員番号</label>
            <div class="form-input">
                <input type="number" id="employer_id" name="employer_id" required value="{{old('employer_id',$user->employer_id )}}">



            </div>
        </div>

        <div class="form-group">
            <label for="name" class="form-label required">氏名</label>
            <div class="form-input">
                <input type="text" id="name" name="name" required value="{{old('name',$user->name )}}">



            </div>
        </div>
        <div class="form-group">
            <label for="furigana" class="form-label required">氏名(ふりがな)</label>
            <div class="form-input">
                <input type="text" id="furigana" name="furigana" required value="{{old('furigana',$user->furigana )}}">

            </div>
        </div>

        <div class="form-group">
            <label for="gender" class="form-label required" >性別</label>
            <div class="form-input">
                <select name="gender" id="gender" required>
                    <option value="男性" {{ old('gender', $user->gender) == '男性' ? 'selected' : '' }}>男性</option>
                    <option value="女性" {{ old('gender', $user->gender) == '女性' ? 'selected' : '' }}>女性</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="birthdate" class="form-label required">生年月日</label>
                <div class="form-input">
                    <input type="date" id="birthdate" name="birthdate" required value="{{ old('birthdate', $user->birthdate) }}">
                </div>
        </div>

        <div class="form-group">
            <label for="post_number" class="form-label required">郵便番号</label>
            <div class="form-input">
                <input type="text" id="post_number" name="post_number" required value="{{ old('post_number', $user->post_number) }}">
            </div>
        </div>
        <div class="form-group">
            <label for="address" class="form-label required">住所</label>
            <input type="text" id="address" name="address" required value="{{ old('address', $user->address) }}">
        </div>

        <div class="form-group">
            <label for="email" class="form-label required">メール</label>
            <div class="form-input">
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}">
                <span class="input-hint">※会社のメールのみ</span>
            </div>
        </div>
        {{-- <div class="form-group">
            <label for="password" class="form-label required">パスワード</label>
            <div class="form-input">
                <input type="password" id="password" name="password" required minlength="8" maxlength="20">
                <span class="input-hint">※変更する場合のみ入力（8～20文字）</span>
            </div>
        </div> --}}

        <div class="form-group">
            <label for="is_boss" class="form-label">上司</label>
            <div class="form-input">
                <input type="checkbox" id="is_boss" name="is_boss" value="1"
                class="form-checkbox h-5 w-5 text-blue-600"
                {{ old('is_boss', $user->is_boss) ? 'checked' : '' }}>
                <span class="input-hint">※上司であればチェックしてください</span>
            </div>
        </div>



        <div class="form-group">
            <label for="roles" class="form-label required">ロール</label>
            <div class="form-input">
                <select name="roles[]" id="roles" required>
                    <option value="">ロール選択</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role }}" {{ in_array($role, $userRoles ?? []) ? 'selected' : '' }}>{{ $role }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- <button type="submit" class="submit-button">追加</button> --}}
        <div class="flex justify-between">
            <x-button purpose="default" type="" href="{{ url('/admin/role-permission/users') }}">
                戻る
            </x-button>
            <x-button purpose="search" type="submit">
                追加
            </x-button>

        </div>


    </form>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const corpSelect = document.getElementById('corp_id');
            const officeSelect = document.getElementById('office_id');
            const divisionSelect = document.getElementById('division_id');

            corpSelect.addEventListener('change', updateOffices);
            officeSelect.addEventListener('change', updateDivisions);

            function updateOffices() {
                const corpId = corpSelect.value;
                officeSelect.innerHTML = '<option value="">営業所選択</option>';
                officeSelect.disabled = true;
                divisionSelect.innerHTML = '<option value="">所属選択</option>';
                divisionSelect.disabled = true;

                if (corpId) {
                    fetch(`/get-offices-for-corp/${corpId}`)
                        .then(response => response.json())
                        .then(offices => {
                            offices.forEach(office => {
                                const option = document.createElement('option');
                                option.value = office.id;
                                option.textContent = office.office_name;
                                officeSelect.appendChild(option);
                            });
                            officeSelect.disabled = false;
                        })
                        .catch(error => console.error('Error:', error));
                }
            }

            function updateDivisions() {
                const officeId = officeSelect.value;
                divisionSelect.innerHTML = '<option value="">所属選択</option>';
                divisionSelect.disabled = true;

                if (officeId) {
                    fetch(`/get-divisions-for-office/${officeId}`)
                        .then(response => response.json())
                        .then(divisions => {
                            divisions.forEach(division => {
                                const option = document.createElement('option');
                                option.value = division.id;
                                option.textContent = division.name;
                                divisionSelect.appendChild(option);
                            });
                            divisionSelect.disabled = false;
                        })
                        .catch(error => console.error('Error:', error));
                }
            }

            // Initialize the dropdowns with the current user's data
            updateOffices();
            updateDivisions();
        });
        </script>
</div>


@endsection




