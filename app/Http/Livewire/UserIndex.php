<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\User;
use Hash;
use Livewire\WithPagination;

class UserIndex extends Component
{
    use WithPagination;

    public $name, $username, $email, $password, $selected_id;
    public $confirming;
    public $updateMode = false;
    public $perPage = 10;
    public $sortField = 'name';
    public $sortAsc = true;
    public $search = '';

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = ! $this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function render()
    {
        return view('livewire.user.user-index', [
            'users' => User::search($this->search)
                        ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                        ->paginate($this->perPage),
        ]);
    }

    private function _resetInput()
    {
        $this->name = null;
        $this->username = null;
        $this->email = null;
        $this->password = null;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string',
            'username' => 'required|min:5|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ], [
            'name.required' => 'nama harus diisi',
            'username.required' => 'username harus diisi',
            'username.unique' => 'username sudah ada',
            'username.min' => 'username minimal 5 karakter',
            'email.required' => 'email harus diisi',
            'email.email' => 'format email harus benar',
            'email.unique' => 'email sudah ada',
            'password.required' => 'password harus diisi',
            'password.min' => 'password minimal 6 karakter'
        ]);

        User::create([
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'password' => Hash::make($this->password)
        ]);

        $this->_resetInput();
        session()->flash('message', 'user berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->selected_id = $user->id;
        $this->name = $user->name;
        $this->username = $user->username;
        $this->email = $user->email;
        // $this->password = $user->password;

        $this->updateMode = true;
    }

    public function update()
    {
        $char = $this->password != '' ? 'min:6' : '';
        
        $this->validate([
            'name' => 'required|string',
            'username' => 'required|min:5',
            'email' => 'required|email',
            'password' => $char
        ], [
            'name.required' => 'nama harus diisi',
            'username.required' => 'username harus diisi',
            'username.min' => 'username minimal 5 karakter',
            'email.required' => 'email harus diisi',
            'email.email' => 'format email harus benar',
            'password.min' => 'password minimal 6 karakter'
        ]);

        if ($this->selected_id) {
            $user = User::find($this->selected_id);
            if ($this->password != '') {
                $user->update([
                    'name' => $this->name,
                    'username' => $this->username,
                    'email' => $this->email,
                    'password' => Hash::make($this->password),
                ]);
            } else {
                $user->update([
                    'name' => $this->name,
                    'username' => $this->username,
                    'email' => $this->email
                ]);
            }
            $this->_resetInput();
            $this->updateMode = false;
            session()->flash('message', 'user berhasil diupdate.');
        }
    }

    public function destroy($id)
    {
        User::where('id', $id)->delete();
        session()->flash('message', 'user berhasil dihapus.');
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->_resetInput();
    }

    public function cancelDelete()
    {
        $this->confirming = '';
    }

    public function confirmDelete($id)
    {
        $this->confirming = $id;
    }
}
