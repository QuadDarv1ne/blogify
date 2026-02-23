<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateAdminCommand extends Command
{
    protected $signature = 'blog:create-admin {email? : Admin email} {--name= : Admin name}';
    protected $description = 'Create an admin user';

    public function handle(): int
    {
        $email = $this->argument('email') ?? $this->option('name') ?? 'admin@example.com';
        
        if (User::where('email', $email)->exists()) {
            $this->error("User with email {$email} already exists!");
            return self::FAILURE;
        }

        $name = $this->option('name') ?? 'Admin';
        $password = $this->secret('Enter password (or press Enter for "password")') ?: 'password';

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'is_admin' => true,
        ]);

        $this->info("Admin user created successfully!");
        $this->line("Email: {$email}");
        $this->line("Password: " . ($password === 'password' ? 'password (default)' : '***'));

        return self::SUCCESS;
    }
}
