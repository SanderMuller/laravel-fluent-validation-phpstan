<?php declare(strict_types=1);

namespace App\Benchmark;

use SanderMuller\FluentValidation\FluentRule;
use SanderMuller\FluentValidation\Rules\ArrayRule;
use SanderMuller\FluentValidation\Rules\StringRule;

/**
 * Large stub file for benchmarking the NoUnboundedArrayEachRule.
 * Contains ~80 non-each chains and ~40 each-containing chains.
 */
final class BenchmarkLargeFile
{
    // --- Non-each chains (should be fast-bailed in visitor) ---
    public function m001(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }

    public function m002(): StringRule
    {
        return FluentRule::string()->email()->nullable();
    }

    public function m003(): StringRule
    {
        return FluentRule::string()->url()->required();
    }

    public function m004(): StringRule
    {
        return FluentRule::string()->alpha()->max(50);
    }

    public function m005(): StringRule
    {
        return FluentRule::string()->numeric()->min(0);
    }

    public function m006(): StringRule
    {
        return FluentRule::string()->required()->regex('/^[a-z]+$/');
    }

    public function m007(): StringRule
    {
        return FluentRule::string()->max(255)->nullable();
    }

    public function m008(): StringRule
    {
        return FluentRule::string()->min(8)->max(72);
    }

    public function m009(): StringRule
    {
        return FluentRule::string()->uuid()->required();
    }

    public function m010(): StringRule
    {
        return FluentRule::string()->in('a', 'b', 'c');
    }

    public function m011(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }

    public function m012(): StringRule
    {
        return FluentRule::string()->email()->nullable();
    }

    public function m013(): StringRule
    {
        return FluentRule::string()->url()->required();
    }

    public function m014(): StringRule
    {
        return FluentRule::string()->alpha()->max(50);
    }

    public function m015(): StringRule
    {
        return FluentRule::string()->numeric()->min(0);
    }

    public function m016(): StringRule
    {
        return FluentRule::string()->required()->regex('/^[a-z]+$/');
    }

    public function m017(): StringRule
    {
        return FluentRule::string()->max(255)->nullable();
    }

    public function m018(): StringRule
    {
        return FluentRule::string()->min(8)->max(72);
    }

    public function m019(): StringRule
    {
        return FluentRule::string()->uuid()->required();
    }

    public function m020(): StringRule
    {
        return FluentRule::string()->in('a', 'b', 'c');
    }

    public function m021(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }

    public function m022(): StringRule
    {
        return FluentRule::string()->email()->nullable();
    }

    public function m023(): StringRule
    {
        return FluentRule::string()->url()->required();
    }

    public function m024(): StringRule
    {
        return FluentRule::string()->alpha()->max(50);
    }

    public function m025(): StringRule
    {
        return FluentRule::string()->numeric()->min(0);
    }

    public function m026(): StringRule
    {
        return FluentRule::string()->required()->regex('/^[a-z]+$/');
    }

    public function m027(): StringRule
    {
        return FluentRule::string()->max(255)->nullable();
    }

    public function m028(): StringRule
    {
        return FluentRule::string()->min(8)->max(72);
    }

    public function m029(): StringRule
    {
        return FluentRule::string()->uuid()->required();
    }

    public function m030(): StringRule
    {
        return FluentRule::string()->in('a', 'b', 'c');
    }

    public function m031(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }

    public function m032(): StringRule
    {
        return FluentRule::string()->email()->nullable();
    }

    public function m033(): StringRule
    {
        return FluentRule::string()->url()->required();
    }

    public function m034(): StringRule
    {
        return FluentRule::string()->alpha()->max(50);
    }

    public function m035(): StringRule
    {
        return FluentRule::string()->numeric()->min(0);
    }

    public function m036(): StringRule
    {
        return FluentRule::string()->required()->regex('/^[a-z]+$/');
    }

    public function m037(): StringRule
    {
        return FluentRule::string()->max(255)->nullable();
    }

    public function m038(): StringRule
    {
        return FluentRule::string()->min(8)->max(72);
    }

    public function m039(): StringRule
    {
        return FluentRule::string()->uuid()->required();
    }

    public function m040(): StringRule
    {
        return FluentRule::string()->in('a', 'b', 'c');
    }

    public function m041(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }

    public function m042(): StringRule
    {
        return FluentRule::string()->email()->nullable();
    }

    public function m043(): StringRule
    {
        return FluentRule::string()->url()->required();
    }

    public function m044(): StringRule
    {
        return FluentRule::string()->alpha()->max(50);
    }

    public function m045(): StringRule
    {
        return FluentRule::string()->numeric()->min(0);
    }

    public function m046(): StringRule
    {
        return FluentRule::string()->required()->regex('/^[a-z]+$/');
    }

    public function m047(): StringRule
    {
        return FluentRule::string()->max(255)->nullable();
    }

    public function m048(): StringRule
    {
        return FluentRule::string()->min(8)->max(72);
    }

    public function m049(): StringRule
    {
        return FluentRule::string()->uuid()->required();
    }

    public function m050(): StringRule
    {
        return FluentRule::string()->in('a', 'b', 'c');
    }

    public function m051(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }

    public function m052(): StringRule
    {
        return FluentRule::string()->email()->nullable();
    }

    public function m053(): StringRule
    {
        return FluentRule::string()->url()->required();
    }

    public function m054(): StringRule
    {
        return FluentRule::string()->alpha()->max(50);
    }

    public function m055(): StringRule
    {
        return FluentRule::string()->numeric()->min(0);
    }

    public function m056(): StringRule
    {
        return FluentRule::string()->required()->regex('/^[a-z]+$/');
    }

    public function m057(): StringRule
    {
        return FluentRule::string()->max(255)->nullable();
    }

    public function m058(): StringRule
    {
        return FluentRule::string()->min(8)->max(72);
    }

    public function m059(): StringRule
    {
        return FluentRule::string()->uuid()->required();
    }

    public function m060(): StringRule
    {
        return FluentRule::string()->in('a', 'b', 'c');
    }

    public function m061(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }

    public function m062(): StringRule
    {
        return FluentRule::string()->email()->nullable();
    }

    public function m063(): StringRule
    {
        return FluentRule::string()->url()->required();
    }

    public function m064(): StringRule
    {
        return FluentRule::string()->alpha()->max(50);
    }

    public function m065(): StringRule
    {
        return FluentRule::string()->numeric()->min(0);
    }

    public function m066(): StringRule
    {
        return FluentRule::string()->required()->regex('/^[a-z]+$/');
    }

    public function m067(): StringRule
    {
        return FluentRule::string()->max(255)->nullable();
    }

    public function m068(): StringRule
    {
        return FluentRule::string()->min(8)->max(72);
    }

    public function m069(): StringRule
    {
        return FluentRule::string()->uuid()->required();
    }

    public function m070(): StringRule
    {
        return FluentRule::string()->in('a', 'b', 'c');
    }

    public function m071(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }

    public function m072(): StringRule
    {
        return FluentRule::string()->email()->nullable();
    }

    public function m073(): StringRule
    {
        return FluentRule::string()->url()->required();
    }

    public function m074(): StringRule
    {
        return FluentRule::string()->alpha()->max(50);
    }

    public function m075(): StringRule
    {
        return FluentRule::string()->numeric()->min(0);
    }

    public function m076(): StringRule
    {
        return FluentRule::string()->required()->regex('/^[a-z]+$/');
    }

    public function m077(): StringRule
    {
        return FluentRule::string()->max(255)->nullable();
    }

    public function m078(): StringRule
    {
        return FluentRule::string()->min(8)->max(72);
    }

    public function m079(): StringRule
    {
        return FluentRule::string()->uuid()->required();
    }

    public function m080(): StringRule
    {
        return FluentRule::string()->in('a', 'b', 'c');
    }

    // --- Each-containing chains (unbounded - each chain processes through full rule logic) ---
    public function e001(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->required());
    }

    public function e002(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->email());
    }

    public function e003(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->url());
    }

    public function e004(): ArrayRule
    {
        return FluentRule::array()->distinct()->each(FluentRule::string());
    }

    public function e005(): ArrayRule
    {
        return FluentRule::array()->min(1)->each(FluentRule::string());
    }

    public function e006(): ArrayRule
    {
        return FluentRule::array()->nullable()->each(FluentRule::string());
    }

    public function e007(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->required());
    }

    public function e008(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->email());
    }

    public function e009(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->url());
    }

    public function e010(): ArrayRule
    {
        return FluentRule::array()->distinct()->each(FluentRule::string());
    }

    // --- Bounded each chains (should be silenced) ---
    public function b001(): ArrayRule
    {
        return FluentRule::array()->max(10)->each(FluentRule::string());
    }

    public function b002(): ArrayRule
    {
        return FluentRule::array()->between(1, 5)->each(FluentRule::string());
    }

    public function b003(): ArrayRule
    {
        return FluentRule::array()->exactly(3)->each(FluentRule::string());
    }

    public function b004(): ArrayRule
    {
        return FluentRule::array(['a', 'b', 'c'])->each(FluentRule::string());
    }

    public function b005(): ArrayRule
    {
        return FluentRule::array()->max(10)->each(FluentRule::string());
    }

    public function b006(): ArrayRule
    {
        return FluentRule::array()->between(1, 5)->each(FluentRule::string());
    }

    public function b007(): ArrayRule
    {
        return FluentRule::array()->exactly(3)->each(FluentRule::string());
    }

    public function b008(): ArrayRule
    {
        return FluentRule::array(['a', 'b', 'c'])->each(FluentRule::string());
    }

    public function b009(): ArrayRule
    {
        return FluentRule::array()->max(10)->each(FluentRule::string());
    }

    public function b010(): ArrayRule
    {
        return FluentRule::array()->between(1, 5)->each(FluentRule::string());
    }

    // --- More non-each chains ---
    public function n001(): StringRule
    {
        return FluentRule::string()->required()->in('x', 'y');
    }

    public function n002(): StringRule
    {
        return FluentRule::string()->nullable()->max(200);
    }

    public function n003(): StringRule
    {
        return FluentRule::string()->required()->min(3)->max(30);
    }

    public function n004(): StringRule
    {
        return FluentRule::string()->alpha_dash()->max(50);
    }

    public function n005(): StringRule
    {
        return FluentRule::string()->alpha_num()->required();
    }

    public function n006(): StringRule
    {
        return FluentRule::string()->starts_with('prefix');
    }

    public function n007(): StringRule
    {
        return FluentRule::string()->ends_with('suffix');
    }

    public function n008(): StringRule
    {
        return FluentRule::string()->date()->required();
    }

    public function n009(): StringRule
    {
        return FluentRule::string()->date_format('Y-m-d');
    }

    public function n010(): StringRule
    {
        return FluentRule::string()->ip()->required();
    }

    public function n011(): StringRule
    {
        return FluentRule::string()->ipv4()->nullable();
    }

    public function n012(): StringRule
    {
        return FluentRule::string()->ipv6()->required();
    }

    public function n013(): StringRule
    {
        return FluentRule::string()->json()->nullable();
    }

    public function n014(): StringRule
    {
        return FluentRule::string()->timezone()->required();
    }

    public function n015(): StringRule
    {
        return FluentRule::string()->lowercase()->max(100);
    }

    public function n016(): StringRule
    {
        return FluentRule::string()->uppercase()->max(100);
    }

    public function n017(): StringRule
    {
        return FluentRule::string()->ascii()->required();
    }

    public function n018(): StringRule
    {
        return FluentRule::string()->hex_color()->nullable();
    }

    public function n019(): StringRule
    {
        return FluentRule::string()->mac_address()->required();
    }

    public function n020(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }
}
