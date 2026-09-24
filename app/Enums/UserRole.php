<?php

namespace App\Enums;

enum UserRole: string
{
    case Superadmin = 'superadmin';
    case Admin = 'admin';
    case Doctor = 'doctor';
    case Nurse = 'nurse';
    case Pharmacist = 'pharmacist';
    case Patient = 'patient';

    /**
     * Get the human-readable label for the role.
     */
    public function label(): string
    {
        return match ($this) {
            self::Superadmin => 'Superadmin',
            self::Admin => 'Administrator',
            self::Doctor => 'Doctor',
            self::Nurse => 'Nurse',
            self::Pharmacist => 'Pharmacist',
            self::Patient => 'Patient',
        };
    }

    /**
     * Get badge styling classes for the role.
     */
    public function badgeClasses(): string
    {
        return match ($this) {
            self::Superadmin => 'bg-purple-100 text-purple-800 border-purple-200 dark:bg-purple-900/40 dark:text-purple-300 dark:border-purple-700/50',
            self::Admin => 'bg-blue-100 text-blue-800 border-blue-200 dark:bg-blue-900/40 dark:text-blue-300 dark:border-blue-700/50',
            self::Doctor => 'bg-emerald-100 text-emerald-800 border-emerald-200 dark:bg-emerald-900/40 dark:text-emerald-300 dark:border-emerald-700/50',
            self::Nurse => 'bg-teal-100 text-teal-800 border-teal-200 dark:bg-teal-900/40 dark:text-teal-300 dark:border-teal-700/50',
            self::Pharmacist => 'bg-amber-100 text-amber-800 border-amber-200 dark:bg-amber-900/40 dark:text-amber-300 dark:border-amber-700/50',
            self::Patient => 'bg-gray-100 text-gray-800 border-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700',
        };
    }

    /**
     * Get icon representation for the role.
     */
    public function icon(): string
    {
        return match ($this) {
            self::Superadmin => '🛡️',
            self::Admin => '⚙️',
            self::Doctor => '🩺',
            self::Nurse => '💉',
            self::Pharmacist => '💊',
            self::Patient => '👤',
        };
    }
}
