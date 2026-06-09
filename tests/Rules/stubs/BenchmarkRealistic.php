<?php declare(strict_types=1);

namespace App\Benchmark;

use SanderMuller\FluentValidation\FluentRule;
use SanderMuller\FluentValidation\Rules\ArrayRule;
use SanderMuller\FluentValidation\Rules\StringRule;

/**
 * Auto-generated benchmark stub — 1000 method chains.
 * 780 non-each, 120 unbounded each (flagged), 100 bounded each.
 */
final class BenchmarkRealistic
{
    public function n0001(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }

    public function n0002(): StringRule
    {
        return FluentRule::string()->email()->nullable();
    }

    public function n0003(): StringRule
    {
        return FluentRule::string()->url()->required();
    }

    public function n0004(): StringRule
    {
        return FluentRule::string()->alpha()->max(50);
    }

    public function n0005(): StringRule
    {
        return FluentRule::string()->uuid()->required();
    }

    public function n0006(): StringRule
    {
        return FluentRule::string()->required()->regex('/^[a-z]+$/');
    }

    public function n0007(): StringRule
    {
        return FluentRule::string()->max(255)->nullable();
    }

    public function n0008(): StringRule
    {
        return FluentRule::string()->min(8)->max(72);
    }

    public function n0009(): StringRule
    {
        return FluentRule::string()->min(1)->max(100);
    }

    public function n0010(): StringRule
    {
        return FluentRule::string()->alphaDash()->max(50);
    }

    public function n0011(): StringRule
    {
        return FluentRule::string()->startsWith('prefix')->required();
    }

    public function n0012(): StringRule
    {
        return FluentRule::string()->endsWith('.com')->nullable();
    }

    public function n0013(): StringRule
    {
        return FluentRule::string()->date()->required();
    }

    public function n0014(): StringRule
    {
        return FluentRule::string()->json()->nullable();
    }

    public function n0015(): StringRule
    {
        return FluentRule::string()->timezone()->required();
    }

    public function n0016(): StringRule
    {
        return FluentRule::string()->lowercase()->max(100);
    }

    public function n0017(): StringRule
    {
        return FluentRule::string()->uppercase()->max(100);
    }

    public function n0018(): StringRule
    {
        return FluentRule::string()->ascii()->required();
    }

    public function n0019(): StringRule
    {
        return FluentRule::string()->hexColor()->nullable();
    }

    public function n0020(): StringRule
    {
        return FluentRule::string()->macAddress()->required();
    }

    public function n0021(): StringRule
    {
        return FluentRule::string()->ip()->required();
    }

    public function n0022(): StringRule
    {
        return FluentRule::string()->ipv4()->nullable();
    }

    public function n0023(): StringRule
    {
        return FluentRule::string()->ipv6()->required();
    }

    public function n0024(): StringRule
    {
        return FluentRule::string()->ulid()->required();
    }

    public function n0025(): StringRule
    {
        return FluentRule::string()->between(2, 100)->required();
    }

    public function n0026(): StringRule
    {
        return FluentRule::string()->exactly(10)->required();
    }

    public function n0027(): StringRule
    {
        return FluentRule::string()->regex('/\d+/')->nullable();
    }

    public function n0028(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }

    public function n0029(): StringRule
    {
        return FluentRule::string()->email()->nullable();
    }

    public function n0030(): StringRule
    {
        return FluentRule::string()->url()->required();
    }

    public function n0031(): StringRule
    {
        return FluentRule::string()->alpha()->max(50);
    }

    public function n0032(): StringRule
    {
        return FluentRule::string()->uuid()->required();
    }

    public function n0033(): StringRule
    {
        return FluentRule::string()->required()->regex('/^[a-z]+$/');
    }

    public function n0034(): StringRule
    {
        return FluentRule::string()->max(255)->nullable();
    }

    public function n0035(): StringRule
    {
        return FluentRule::string()->min(8)->max(72);
    }

    public function n0036(): StringRule
    {
        return FluentRule::string()->min(1)->max(100);
    }

    public function n0037(): StringRule
    {
        return FluentRule::string()->alphaDash()->max(50);
    }

    public function n0038(): StringRule
    {
        return FluentRule::string()->startsWith('prefix')->required();
    }

    public function n0039(): StringRule
    {
        return FluentRule::string()->endsWith('.com')->nullable();
    }

    public function n0040(): StringRule
    {
        return FluentRule::string()->date()->required();
    }

    public function n0041(): StringRule
    {
        return FluentRule::string()->json()->nullable();
    }

    public function n0042(): StringRule
    {
        return FluentRule::string()->timezone()->required();
    }

    public function n0043(): StringRule
    {
        return FluentRule::string()->lowercase()->max(100);
    }

    public function n0044(): StringRule
    {
        return FluentRule::string()->uppercase()->max(100);
    }

    public function n0045(): StringRule
    {
        return FluentRule::string()->ascii()->required();
    }

    public function n0046(): StringRule
    {
        return FluentRule::string()->hexColor()->nullable();
    }

    public function n0047(): StringRule
    {
        return FluentRule::string()->macAddress()->required();
    }

    public function n0048(): StringRule
    {
        return FluentRule::string()->ip()->required();
    }

    public function n0049(): StringRule
    {
        return FluentRule::string()->ipv4()->nullable();
    }

    public function n0050(): StringRule
    {
        return FluentRule::string()->ipv6()->required();
    }

    public function n0051(): StringRule
    {
        return FluentRule::string()->ulid()->required();
    }

    public function n0052(): StringRule
    {
        return FluentRule::string()->between(2, 100)->required();
    }

    public function n0053(): StringRule
    {
        return FluentRule::string()->exactly(10)->required();
    }

    public function n0054(): StringRule
    {
        return FluentRule::string()->regex('/\d+/')->nullable();
    }

    public function n0055(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }

    public function n0056(): StringRule
    {
        return FluentRule::string()->email()->nullable();
    }

    public function n0057(): StringRule
    {
        return FluentRule::string()->url()->required();
    }

    public function n0058(): StringRule
    {
        return FluentRule::string()->alpha()->max(50);
    }

    public function n0059(): StringRule
    {
        return FluentRule::string()->uuid()->required();
    }

    public function n0060(): StringRule
    {
        return FluentRule::string()->required()->regex('/^[a-z]+$/');
    }

    public function n0061(): StringRule
    {
        return FluentRule::string()->max(255)->nullable();
    }

    public function n0062(): StringRule
    {
        return FluentRule::string()->min(8)->max(72);
    }

    public function n0063(): StringRule
    {
        return FluentRule::string()->min(1)->max(100);
    }

    public function n0064(): StringRule
    {
        return FluentRule::string()->alphaDash()->max(50);
    }

    public function n0065(): StringRule
    {
        return FluentRule::string()->startsWith('prefix')->required();
    }

    public function n0066(): StringRule
    {
        return FluentRule::string()->endsWith('.com')->nullable();
    }

    public function n0067(): StringRule
    {
        return FluentRule::string()->date()->required();
    }

    public function n0068(): StringRule
    {
        return FluentRule::string()->json()->nullable();
    }

    public function n0069(): StringRule
    {
        return FluentRule::string()->timezone()->required();
    }

    public function n0070(): StringRule
    {
        return FluentRule::string()->lowercase()->max(100);
    }

    public function n0071(): StringRule
    {
        return FluentRule::string()->uppercase()->max(100);
    }

    public function n0072(): StringRule
    {
        return FluentRule::string()->ascii()->required();
    }

    public function n0073(): StringRule
    {
        return FluentRule::string()->hexColor()->nullable();
    }

    public function n0074(): StringRule
    {
        return FluentRule::string()->macAddress()->required();
    }

    public function n0075(): StringRule
    {
        return FluentRule::string()->ip()->required();
    }

    public function n0076(): StringRule
    {
        return FluentRule::string()->ipv4()->nullable();
    }

    public function n0077(): StringRule
    {
        return FluentRule::string()->ipv6()->required();
    }

    public function n0078(): StringRule
    {
        return FluentRule::string()->ulid()->required();
    }

    public function n0079(): StringRule
    {
        return FluentRule::string()->between(2, 100)->required();
    }

    public function n0080(): StringRule
    {
        return FluentRule::string()->exactly(10)->required();
    }

    public function n0081(): StringRule
    {
        return FluentRule::string()->regex('/\d+/')->nullable();
    }

    public function n0082(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }

    public function n0083(): StringRule
    {
        return FluentRule::string()->email()->nullable();
    }

    public function n0084(): StringRule
    {
        return FluentRule::string()->url()->required();
    }

    public function n0085(): StringRule
    {
        return FluentRule::string()->alpha()->max(50);
    }

    public function n0086(): StringRule
    {
        return FluentRule::string()->uuid()->required();
    }

    public function n0087(): StringRule
    {
        return FluentRule::string()->required()->regex('/^[a-z]+$/');
    }

    public function n0088(): StringRule
    {
        return FluentRule::string()->max(255)->nullable();
    }

    public function n0089(): StringRule
    {
        return FluentRule::string()->min(8)->max(72);
    }

    public function n0090(): StringRule
    {
        return FluentRule::string()->min(1)->max(100);
    }

    public function n0091(): StringRule
    {
        return FluentRule::string()->alphaDash()->max(50);
    }

    public function n0092(): StringRule
    {
        return FluentRule::string()->startsWith('prefix')->required();
    }

    public function n0093(): StringRule
    {
        return FluentRule::string()->endsWith('.com')->nullable();
    }

    public function n0094(): StringRule
    {
        return FluentRule::string()->date()->required();
    }

    public function n0095(): StringRule
    {
        return FluentRule::string()->json()->nullable();
    }

    public function n0096(): StringRule
    {
        return FluentRule::string()->timezone()->required();
    }

    public function n0097(): StringRule
    {
        return FluentRule::string()->lowercase()->max(100);
    }

    public function n0098(): StringRule
    {
        return FluentRule::string()->uppercase()->max(100);
    }

    public function n0099(): StringRule
    {
        return FluentRule::string()->ascii()->required();
    }

    public function n0100(): StringRule
    {
        return FluentRule::string()->hexColor()->nullable();
    }

    public function n0101(): StringRule
    {
        return FluentRule::string()->macAddress()->required();
    }

    public function n0102(): StringRule
    {
        return FluentRule::string()->ip()->required();
    }

    public function n0103(): StringRule
    {
        return FluentRule::string()->ipv4()->nullable();
    }

    public function n0104(): StringRule
    {
        return FluentRule::string()->ipv6()->required();
    }

    public function n0105(): StringRule
    {
        return FluentRule::string()->ulid()->required();
    }

    public function n0106(): StringRule
    {
        return FluentRule::string()->between(2, 100)->required();
    }

    public function n0107(): StringRule
    {
        return FluentRule::string()->exactly(10)->required();
    }

    public function n0108(): StringRule
    {
        return FluentRule::string()->regex('/\d+/')->nullable();
    }

    public function n0109(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }

    public function n0110(): StringRule
    {
        return FluentRule::string()->email()->nullable();
    }

    public function n0111(): StringRule
    {
        return FluentRule::string()->url()->required();
    }

    public function n0112(): StringRule
    {
        return FluentRule::string()->alpha()->max(50);
    }

    public function n0113(): StringRule
    {
        return FluentRule::string()->uuid()->required();
    }

    public function n0114(): StringRule
    {
        return FluentRule::string()->required()->regex('/^[a-z]+$/');
    }

    public function n0115(): StringRule
    {
        return FluentRule::string()->max(255)->nullable();
    }

    public function n0116(): StringRule
    {
        return FluentRule::string()->min(8)->max(72);
    }

    public function n0117(): StringRule
    {
        return FluentRule::string()->min(1)->max(100);
    }

    public function n0118(): StringRule
    {
        return FluentRule::string()->alphaDash()->max(50);
    }

    public function n0119(): StringRule
    {
        return FluentRule::string()->startsWith('prefix')->required();
    }

    public function n0120(): StringRule
    {
        return FluentRule::string()->endsWith('.com')->nullable();
    }

    public function n0121(): StringRule
    {
        return FluentRule::string()->date()->required();
    }

    public function n0122(): StringRule
    {
        return FluentRule::string()->json()->nullable();
    }

    public function n0123(): StringRule
    {
        return FluentRule::string()->timezone()->required();
    }

    public function n0124(): StringRule
    {
        return FluentRule::string()->lowercase()->max(100);
    }

    public function n0125(): StringRule
    {
        return FluentRule::string()->uppercase()->max(100);
    }

    public function n0126(): StringRule
    {
        return FluentRule::string()->ascii()->required();
    }

    public function n0127(): StringRule
    {
        return FluentRule::string()->hexColor()->nullable();
    }

    public function n0128(): StringRule
    {
        return FluentRule::string()->macAddress()->required();
    }

    public function n0129(): StringRule
    {
        return FluentRule::string()->ip()->required();
    }

    public function n0130(): StringRule
    {
        return FluentRule::string()->ipv4()->nullable();
    }

    public function n0131(): StringRule
    {
        return FluentRule::string()->ipv6()->required();
    }

    public function n0132(): StringRule
    {
        return FluentRule::string()->ulid()->required();
    }

    public function n0133(): StringRule
    {
        return FluentRule::string()->between(2, 100)->required();
    }

    public function n0134(): StringRule
    {
        return FluentRule::string()->exactly(10)->required();
    }

    public function n0135(): StringRule
    {
        return FluentRule::string()->regex('/\d+/')->nullable();
    }

    public function n0136(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }

    public function n0137(): StringRule
    {
        return FluentRule::string()->email()->nullable();
    }

    public function n0138(): StringRule
    {
        return FluentRule::string()->url()->required();
    }

    public function n0139(): StringRule
    {
        return FluentRule::string()->alpha()->max(50);
    }

    public function n0140(): StringRule
    {
        return FluentRule::string()->uuid()->required();
    }

    public function n0141(): StringRule
    {
        return FluentRule::string()->required()->regex('/^[a-z]+$/');
    }

    public function n0142(): StringRule
    {
        return FluentRule::string()->max(255)->nullable();
    }

    public function n0143(): StringRule
    {
        return FluentRule::string()->min(8)->max(72);
    }

    public function n0144(): StringRule
    {
        return FluentRule::string()->min(1)->max(100);
    }

    public function n0145(): StringRule
    {
        return FluentRule::string()->alphaDash()->max(50);
    }

    public function n0146(): StringRule
    {
        return FluentRule::string()->startsWith('prefix')->required();
    }

    public function n0147(): StringRule
    {
        return FluentRule::string()->endsWith('.com')->nullable();
    }

    public function n0148(): StringRule
    {
        return FluentRule::string()->date()->required();
    }

    public function n0149(): StringRule
    {
        return FluentRule::string()->json()->nullable();
    }

    public function n0150(): StringRule
    {
        return FluentRule::string()->timezone()->required();
    }

    public function n0151(): StringRule
    {
        return FluentRule::string()->lowercase()->max(100);
    }

    public function n0152(): StringRule
    {
        return FluentRule::string()->uppercase()->max(100);
    }

    public function n0153(): StringRule
    {
        return FluentRule::string()->ascii()->required();
    }

    public function n0154(): StringRule
    {
        return FluentRule::string()->hexColor()->nullable();
    }

    public function n0155(): StringRule
    {
        return FluentRule::string()->macAddress()->required();
    }

    public function n0156(): StringRule
    {
        return FluentRule::string()->ip()->required();
    }

    public function n0157(): StringRule
    {
        return FluentRule::string()->ipv4()->nullable();
    }

    public function n0158(): StringRule
    {
        return FluentRule::string()->ipv6()->required();
    }

    public function n0159(): StringRule
    {
        return FluentRule::string()->ulid()->required();
    }

    public function n0160(): StringRule
    {
        return FluentRule::string()->between(2, 100)->required();
    }

    public function n0161(): StringRule
    {
        return FluentRule::string()->exactly(10)->required();
    }

    public function n0162(): StringRule
    {
        return FluentRule::string()->regex('/\d+/')->nullable();
    }

    public function n0163(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }

    public function n0164(): StringRule
    {
        return FluentRule::string()->email()->nullable();
    }

    public function n0165(): StringRule
    {
        return FluentRule::string()->url()->required();
    }

    public function n0166(): StringRule
    {
        return FluentRule::string()->alpha()->max(50);
    }

    public function n0167(): StringRule
    {
        return FluentRule::string()->uuid()->required();
    }

    public function n0168(): StringRule
    {
        return FluentRule::string()->required()->regex('/^[a-z]+$/');
    }

    public function n0169(): StringRule
    {
        return FluentRule::string()->max(255)->nullable();
    }

    public function n0170(): StringRule
    {
        return FluentRule::string()->min(8)->max(72);
    }

    public function n0171(): StringRule
    {
        return FluentRule::string()->min(1)->max(100);
    }

    public function n0172(): StringRule
    {
        return FluentRule::string()->alphaDash()->max(50);
    }

    public function n0173(): StringRule
    {
        return FluentRule::string()->startsWith('prefix')->required();
    }

    public function n0174(): StringRule
    {
        return FluentRule::string()->endsWith('.com')->nullable();
    }

    public function n0175(): StringRule
    {
        return FluentRule::string()->date()->required();
    }

    public function n0176(): StringRule
    {
        return FluentRule::string()->json()->nullable();
    }

    public function n0177(): StringRule
    {
        return FluentRule::string()->timezone()->required();
    }

    public function n0178(): StringRule
    {
        return FluentRule::string()->lowercase()->max(100);
    }

    public function n0179(): StringRule
    {
        return FluentRule::string()->uppercase()->max(100);
    }

    public function n0180(): StringRule
    {
        return FluentRule::string()->ascii()->required();
    }

    public function n0181(): StringRule
    {
        return FluentRule::string()->hexColor()->nullable();
    }

    public function n0182(): StringRule
    {
        return FluentRule::string()->macAddress()->required();
    }

    public function n0183(): StringRule
    {
        return FluentRule::string()->ip()->required();
    }

    public function n0184(): StringRule
    {
        return FluentRule::string()->ipv4()->nullable();
    }

    public function n0185(): StringRule
    {
        return FluentRule::string()->ipv6()->required();
    }

    public function n0186(): StringRule
    {
        return FluentRule::string()->ulid()->required();
    }

    public function n0187(): StringRule
    {
        return FluentRule::string()->between(2, 100)->required();
    }

    public function n0188(): StringRule
    {
        return FluentRule::string()->exactly(10)->required();
    }

    public function n0189(): StringRule
    {
        return FluentRule::string()->regex('/\d+/')->nullable();
    }

    public function n0190(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }

    public function n0191(): StringRule
    {
        return FluentRule::string()->email()->nullable();
    }

    public function n0192(): StringRule
    {
        return FluentRule::string()->url()->required();
    }

    public function n0193(): StringRule
    {
        return FluentRule::string()->alpha()->max(50);
    }

    public function n0194(): StringRule
    {
        return FluentRule::string()->uuid()->required();
    }

    public function n0195(): StringRule
    {
        return FluentRule::string()->required()->regex('/^[a-z]+$/');
    }

    public function n0196(): StringRule
    {
        return FluentRule::string()->max(255)->nullable();
    }

    public function n0197(): StringRule
    {
        return FluentRule::string()->min(8)->max(72);
    }

    public function n0198(): StringRule
    {
        return FluentRule::string()->min(1)->max(100);
    }

    public function n0199(): StringRule
    {
        return FluentRule::string()->alphaDash()->max(50);
    }

    public function n0200(): StringRule
    {
        return FluentRule::string()->startsWith('prefix')->required();
    }

    public function n0201(): StringRule
    {
        return FluentRule::string()->endsWith('.com')->nullable();
    }

    public function n0202(): StringRule
    {
        return FluentRule::string()->date()->required();
    }

    public function n0203(): StringRule
    {
        return FluentRule::string()->json()->nullable();
    }

    public function n0204(): StringRule
    {
        return FluentRule::string()->timezone()->required();
    }

    public function n0205(): StringRule
    {
        return FluentRule::string()->lowercase()->max(100);
    }

    public function n0206(): StringRule
    {
        return FluentRule::string()->uppercase()->max(100);
    }

    public function n0207(): StringRule
    {
        return FluentRule::string()->ascii()->required();
    }

    public function n0208(): StringRule
    {
        return FluentRule::string()->hexColor()->nullable();
    }

    public function n0209(): StringRule
    {
        return FluentRule::string()->macAddress()->required();
    }

    public function n0210(): StringRule
    {
        return FluentRule::string()->ip()->required();
    }

    public function n0211(): StringRule
    {
        return FluentRule::string()->ipv4()->nullable();
    }

    public function n0212(): StringRule
    {
        return FluentRule::string()->ipv6()->required();
    }

    public function n0213(): StringRule
    {
        return FluentRule::string()->ulid()->required();
    }

    public function n0214(): StringRule
    {
        return FluentRule::string()->between(2, 100)->required();
    }

    public function n0215(): StringRule
    {
        return FluentRule::string()->exactly(10)->required();
    }

    public function n0216(): StringRule
    {
        return FluentRule::string()->regex('/\d+/')->nullable();
    }

    public function n0217(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }

    public function n0218(): StringRule
    {
        return FluentRule::string()->email()->nullable();
    }

    public function n0219(): StringRule
    {
        return FluentRule::string()->url()->required();
    }

    public function n0220(): StringRule
    {
        return FluentRule::string()->alpha()->max(50);
    }

    public function n0221(): StringRule
    {
        return FluentRule::string()->uuid()->required();
    }

    public function n0222(): StringRule
    {
        return FluentRule::string()->required()->regex('/^[a-z]+$/');
    }

    public function n0223(): StringRule
    {
        return FluentRule::string()->max(255)->nullable();
    }

    public function n0224(): StringRule
    {
        return FluentRule::string()->min(8)->max(72);
    }

    public function n0225(): StringRule
    {
        return FluentRule::string()->min(1)->max(100);
    }

    public function n0226(): StringRule
    {
        return FluentRule::string()->alphaDash()->max(50);
    }

    public function n0227(): StringRule
    {
        return FluentRule::string()->startsWith('prefix')->required();
    }

    public function n0228(): StringRule
    {
        return FluentRule::string()->endsWith('.com')->nullable();
    }

    public function n0229(): StringRule
    {
        return FluentRule::string()->date()->required();
    }

    public function n0230(): StringRule
    {
        return FluentRule::string()->json()->nullable();
    }

    public function n0231(): StringRule
    {
        return FluentRule::string()->timezone()->required();
    }

    public function n0232(): StringRule
    {
        return FluentRule::string()->lowercase()->max(100);
    }

    public function n0233(): StringRule
    {
        return FluentRule::string()->uppercase()->max(100);
    }

    public function n0234(): StringRule
    {
        return FluentRule::string()->ascii()->required();
    }

    public function n0235(): StringRule
    {
        return FluentRule::string()->hexColor()->nullable();
    }

    public function n0236(): StringRule
    {
        return FluentRule::string()->macAddress()->required();
    }

    public function n0237(): StringRule
    {
        return FluentRule::string()->ip()->required();
    }

    public function n0238(): StringRule
    {
        return FluentRule::string()->ipv4()->nullable();
    }

    public function n0239(): StringRule
    {
        return FluentRule::string()->ipv6()->required();
    }

    public function n0240(): StringRule
    {
        return FluentRule::string()->ulid()->required();
    }

    public function n0241(): StringRule
    {
        return FluentRule::string()->between(2, 100)->required();
    }

    public function n0242(): StringRule
    {
        return FluentRule::string()->exactly(10)->required();
    }

    public function n0243(): StringRule
    {
        return FluentRule::string()->regex('/\d+/')->nullable();
    }

    public function n0244(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }

    public function n0245(): StringRule
    {
        return FluentRule::string()->email()->nullable();
    }

    public function n0246(): StringRule
    {
        return FluentRule::string()->url()->required();
    }

    public function n0247(): StringRule
    {
        return FluentRule::string()->alpha()->max(50);
    }

    public function n0248(): StringRule
    {
        return FluentRule::string()->uuid()->required();
    }

    public function n0249(): StringRule
    {
        return FluentRule::string()->required()->regex('/^[a-z]+$/');
    }

    public function n0250(): StringRule
    {
        return FluentRule::string()->max(255)->nullable();
    }

    public function n0251(): StringRule
    {
        return FluentRule::string()->min(8)->max(72);
    }

    public function n0252(): StringRule
    {
        return FluentRule::string()->min(1)->max(100);
    }

    public function n0253(): StringRule
    {
        return FluentRule::string()->alphaDash()->max(50);
    }

    public function n0254(): StringRule
    {
        return FluentRule::string()->startsWith('prefix')->required();
    }

    public function n0255(): StringRule
    {
        return FluentRule::string()->endsWith('.com')->nullable();
    }

    public function n0256(): StringRule
    {
        return FluentRule::string()->date()->required();
    }

    public function n0257(): StringRule
    {
        return FluentRule::string()->json()->nullable();
    }

    public function n0258(): StringRule
    {
        return FluentRule::string()->timezone()->required();
    }

    public function n0259(): StringRule
    {
        return FluentRule::string()->lowercase()->max(100);
    }

    public function n0260(): StringRule
    {
        return FluentRule::string()->uppercase()->max(100);
    }

    public function n0261(): StringRule
    {
        return FluentRule::string()->ascii()->required();
    }

    public function n0262(): StringRule
    {
        return FluentRule::string()->hexColor()->nullable();
    }

    public function n0263(): StringRule
    {
        return FluentRule::string()->macAddress()->required();
    }

    public function n0264(): StringRule
    {
        return FluentRule::string()->ip()->required();
    }

    public function n0265(): StringRule
    {
        return FluentRule::string()->ipv4()->nullable();
    }

    public function n0266(): StringRule
    {
        return FluentRule::string()->ipv6()->required();
    }

    public function n0267(): StringRule
    {
        return FluentRule::string()->ulid()->required();
    }

    public function n0268(): StringRule
    {
        return FluentRule::string()->between(2, 100)->required();
    }

    public function n0269(): StringRule
    {
        return FluentRule::string()->exactly(10)->required();
    }

    public function n0270(): StringRule
    {
        return FluentRule::string()->regex('/\d+/')->nullable();
    }

    public function n0271(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }

    public function n0272(): StringRule
    {
        return FluentRule::string()->email()->nullable();
    }

    public function n0273(): StringRule
    {
        return FluentRule::string()->url()->required();
    }

    public function n0274(): StringRule
    {
        return FluentRule::string()->alpha()->max(50);
    }

    public function n0275(): StringRule
    {
        return FluentRule::string()->uuid()->required();
    }

    public function n0276(): StringRule
    {
        return FluentRule::string()->required()->regex('/^[a-z]+$/');
    }

    public function n0277(): StringRule
    {
        return FluentRule::string()->max(255)->nullable();
    }

    public function n0278(): StringRule
    {
        return FluentRule::string()->min(8)->max(72);
    }

    public function n0279(): StringRule
    {
        return FluentRule::string()->min(1)->max(100);
    }

    public function n0280(): StringRule
    {
        return FluentRule::string()->alphaDash()->max(50);
    }

    public function n0281(): StringRule
    {
        return FluentRule::string()->startsWith('prefix')->required();
    }

    public function n0282(): StringRule
    {
        return FluentRule::string()->endsWith('.com')->nullable();
    }

    public function n0283(): StringRule
    {
        return FluentRule::string()->date()->required();
    }

    public function n0284(): StringRule
    {
        return FluentRule::string()->json()->nullable();
    }

    public function n0285(): StringRule
    {
        return FluentRule::string()->timezone()->required();
    }

    public function n0286(): StringRule
    {
        return FluentRule::string()->lowercase()->max(100);
    }

    public function n0287(): StringRule
    {
        return FluentRule::string()->uppercase()->max(100);
    }

    public function n0288(): StringRule
    {
        return FluentRule::string()->ascii()->required();
    }

    public function n0289(): StringRule
    {
        return FluentRule::string()->hexColor()->nullable();
    }

    public function n0290(): StringRule
    {
        return FluentRule::string()->macAddress()->required();
    }

    public function n0291(): StringRule
    {
        return FluentRule::string()->ip()->required();
    }

    public function n0292(): StringRule
    {
        return FluentRule::string()->ipv4()->nullable();
    }

    public function n0293(): StringRule
    {
        return FluentRule::string()->ipv6()->required();
    }

    public function n0294(): StringRule
    {
        return FluentRule::string()->ulid()->required();
    }

    public function n0295(): StringRule
    {
        return FluentRule::string()->between(2, 100)->required();
    }

    public function n0296(): StringRule
    {
        return FluentRule::string()->exactly(10)->required();
    }

    public function n0297(): StringRule
    {
        return FluentRule::string()->regex('/\d+/')->nullable();
    }

    public function n0298(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }

    public function n0299(): StringRule
    {
        return FluentRule::string()->email()->nullable();
    }

    public function n0300(): StringRule
    {
        return FluentRule::string()->url()->required();
    }

    public function n0301(): StringRule
    {
        return FluentRule::string()->alpha()->max(50);
    }

    public function n0302(): StringRule
    {
        return FluentRule::string()->uuid()->required();
    }

    public function n0303(): StringRule
    {
        return FluentRule::string()->required()->regex('/^[a-z]+$/');
    }

    public function n0304(): StringRule
    {
        return FluentRule::string()->max(255)->nullable();
    }

    public function n0305(): StringRule
    {
        return FluentRule::string()->min(8)->max(72);
    }

    public function n0306(): StringRule
    {
        return FluentRule::string()->min(1)->max(100);
    }

    public function n0307(): StringRule
    {
        return FluentRule::string()->alphaDash()->max(50);
    }

    public function n0308(): StringRule
    {
        return FluentRule::string()->startsWith('prefix')->required();
    }

    public function n0309(): StringRule
    {
        return FluentRule::string()->endsWith('.com')->nullable();
    }

    public function n0310(): StringRule
    {
        return FluentRule::string()->date()->required();
    }

    public function n0311(): StringRule
    {
        return FluentRule::string()->json()->nullable();
    }

    public function n0312(): StringRule
    {
        return FluentRule::string()->timezone()->required();
    }

    public function n0313(): StringRule
    {
        return FluentRule::string()->lowercase()->max(100);
    }

    public function n0314(): StringRule
    {
        return FluentRule::string()->uppercase()->max(100);
    }

    public function n0315(): StringRule
    {
        return FluentRule::string()->ascii()->required();
    }

    public function n0316(): StringRule
    {
        return FluentRule::string()->hexColor()->nullable();
    }

    public function n0317(): StringRule
    {
        return FluentRule::string()->macAddress()->required();
    }

    public function n0318(): StringRule
    {
        return FluentRule::string()->ip()->required();
    }

    public function n0319(): StringRule
    {
        return FluentRule::string()->ipv4()->nullable();
    }

    public function n0320(): StringRule
    {
        return FluentRule::string()->ipv6()->required();
    }

    public function n0321(): StringRule
    {
        return FluentRule::string()->ulid()->required();
    }

    public function n0322(): StringRule
    {
        return FluentRule::string()->between(2, 100)->required();
    }

    public function n0323(): StringRule
    {
        return FluentRule::string()->exactly(10)->required();
    }

    public function n0324(): StringRule
    {
        return FluentRule::string()->regex('/\d+/')->nullable();
    }

    public function n0325(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }

    public function n0326(): StringRule
    {
        return FluentRule::string()->email()->nullable();
    }

    public function n0327(): StringRule
    {
        return FluentRule::string()->url()->required();
    }

    public function n0328(): StringRule
    {
        return FluentRule::string()->alpha()->max(50);
    }

    public function n0329(): StringRule
    {
        return FluentRule::string()->uuid()->required();
    }

    public function n0330(): StringRule
    {
        return FluentRule::string()->required()->regex('/^[a-z]+$/');
    }

    public function n0331(): StringRule
    {
        return FluentRule::string()->max(255)->nullable();
    }

    public function n0332(): StringRule
    {
        return FluentRule::string()->min(8)->max(72);
    }

    public function n0333(): StringRule
    {
        return FluentRule::string()->min(1)->max(100);
    }

    public function n0334(): StringRule
    {
        return FluentRule::string()->alphaDash()->max(50);
    }

    public function n0335(): StringRule
    {
        return FluentRule::string()->startsWith('prefix')->required();
    }

    public function n0336(): StringRule
    {
        return FluentRule::string()->endsWith('.com')->nullable();
    }

    public function n0337(): StringRule
    {
        return FluentRule::string()->date()->required();
    }

    public function n0338(): StringRule
    {
        return FluentRule::string()->json()->nullable();
    }

    public function n0339(): StringRule
    {
        return FluentRule::string()->timezone()->required();
    }

    public function n0340(): StringRule
    {
        return FluentRule::string()->lowercase()->max(100);
    }

    public function n0341(): StringRule
    {
        return FluentRule::string()->uppercase()->max(100);
    }

    public function n0342(): StringRule
    {
        return FluentRule::string()->ascii()->required();
    }

    public function n0343(): StringRule
    {
        return FluentRule::string()->hexColor()->nullable();
    }

    public function n0344(): StringRule
    {
        return FluentRule::string()->macAddress()->required();
    }

    public function n0345(): StringRule
    {
        return FluentRule::string()->ip()->required();
    }

    public function n0346(): StringRule
    {
        return FluentRule::string()->ipv4()->nullable();
    }

    public function n0347(): StringRule
    {
        return FluentRule::string()->ipv6()->required();
    }

    public function n0348(): StringRule
    {
        return FluentRule::string()->ulid()->required();
    }

    public function n0349(): StringRule
    {
        return FluentRule::string()->between(2, 100)->required();
    }

    public function n0350(): StringRule
    {
        return FluentRule::string()->exactly(10)->required();
    }

    public function n0351(): StringRule
    {
        return FluentRule::string()->regex('/\d+/')->nullable();
    }

    public function n0352(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }

    public function n0353(): StringRule
    {
        return FluentRule::string()->email()->nullable();
    }

    public function n0354(): StringRule
    {
        return FluentRule::string()->url()->required();
    }

    public function n0355(): StringRule
    {
        return FluentRule::string()->alpha()->max(50);
    }

    public function n0356(): StringRule
    {
        return FluentRule::string()->uuid()->required();
    }

    public function n0357(): StringRule
    {
        return FluentRule::string()->required()->regex('/^[a-z]+$/');
    }

    public function n0358(): StringRule
    {
        return FluentRule::string()->max(255)->nullable();
    }

    public function n0359(): StringRule
    {
        return FluentRule::string()->min(8)->max(72);
    }

    public function n0360(): StringRule
    {
        return FluentRule::string()->min(1)->max(100);
    }

    public function n0361(): StringRule
    {
        return FluentRule::string()->alphaDash()->max(50);
    }

    public function n0362(): StringRule
    {
        return FluentRule::string()->startsWith('prefix')->required();
    }

    public function n0363(): StringRule
    {
        return FluentRule::string()->endsWith('.com')->nullable();
    }

    public function n0364(): StringRule
    {
        return FluentRule::string()->date()->required();
    }

    public function n0365(): StringRule
    {
        return FluentRule::string()->json()->nullable();
    }

    public function n0366(): StringRule
    {
        return FluentRule::string()->timezone()->required();
    }

    public function n0367(): StringRule
    {
        return FluentRule::string()->lowercase()->max(100);
    }

    public function n0368(): StringRule
    {
        return FluentRule::string()->uppercase()->max(100);
    }

    public function n0369(): StringRule
    {
        return FluentRule::string()->ascii()->required();
    }

    public function n0370(): StringRule
    {
        return FluentRule::string()->hexColor()->nullable();
    }

    public function n0371(): StringRule
    {
        return FluentRule::string()->macAddress()->required();
    }

    public function n0372(): StringRule
    {
        return FluentRule::string()->ip()->required();
    }

    public function n0373(): StringRule
    {
        return FluentRule::string()->ipv4()->nullable();
    }

    public function n0374(): StringRule
    {
        return FluentRule::string()->ipv6()->required();
    }

    public function n0375(): StringRule
    {
        return FluentRule::string()->ulid()->required();
    }

    public function n0376(): StringRule
    {
        return FluentRule::string()->between(2, 100)->required();
    }

    public function n0377(): StringRule
    {
        return FluentRule::string()->exactly(10)->required();
    }

    public function n0378(): StringRule
    {
        return FluentRule::string()->regex('/\d+/')->nullable();
    }

    public function n0379(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }

    public function n0380(): StringRule
    {
        return FluentRule::string()->email()->nullable();
    }

    public function n0381(): StringRule
    {
        return FluentRule::string()->url()->required();
    }

    public function n0382(): StringRule
    {
        return FluentRule::string()->alpha()->max(50);
    }

    public function n0383(): StringRule
    {
        return FluentRule::string()->uuid()->required();
    }

    public function n0384(): StringRule
    {
        return FluentRule::string()->required()->regex('/^[a-z]+$/');
    }

    public function n0385(): StringRule
    {
        return FluentRule::string()->max(255)->nullable();
    }

    public function n0386(): StringRule
    {
        return FluentRule::string()->min(8)->max(72);
    }

    public function n0387(): StringRule
    {
        return FluentRule::string()->min(1)->max(100);
    }

    public function n0388(): StringRule
    {
        return FluentRule::string()->alphaDash()->max(50);
    }

    public function n0389(): StringRule
    {
        return FluentRule::string()->startsWith('prefix')->required();
    }

    public function n0390(): StringRule
    {
        return FluentRule::string()->endsWith('.com')->nullable();
    }

    public function n0391(): StringRule
    {
        return FluentRule::string()->date()->required();
    }

    public function n0392(): StringRule
    {
        return FluentRule::string()->json()->nullable();
    }

    public function n0393(): StringRule
    {
        return FluentRule::string()->timezone()->required();
    }

    public function n0394(): StringRule
    {
        return FluentRule::string()->lowercase()->max(100);
    }

    public function n0395(): StringRule
    {
        return FluentRule::string()->uppercase()->max(100);
    }

    public function n0396(): StringRule
    {
        return FluentRule::string()->ascii()->required();
    }

    public function n0397(): StringRule
    {
        return FluentRule::string()->hexColor()->nullable();
    }

    public function n0398(): StringRule
    {
        return FluentRule::string()->macAddress()->required();
    }

    public function n0399(): StringRule
    {
        return FluentRule::string()->ip()->required();
    }

    public function n0400(): StringRule
    {
        return FluentRule::string()->ipv4()->nullable();
    }

    public function n0401(): StringRule
    {
        return FluentRule::string()->ipv6()->required();
    }

    public function n0402(): StringRule
    {
        return FluentRule::string()->ulid()->required();
    }

    public function n0403(): StringRule
    {
        return FluentRule::string()->between(2, 100)->required();
    }

    public function n0404(): StringRule
    {
        return FluentRule::string()->exactly(10)->required();
    }

    public function n0405(): StringRule
    {
        return FluentRule::string()->regex('/\d+/')->nullable();
    }

    public function n0406(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }

    public function n0407(): StringRule
    {
        return FluentRule::string()->email()->nullable();
    }

    public function n0408(): StringRule
    {
        return FluentRule::string()->url()->required();
    }

    public function n0409(): StringRule
    {
        return FluentRule::string()->alpha()->max(50);
    }

    public function n0410(): StringRule
    {
        return FluentRule::string()->uuid()->required();
    }

    public function n0411(): StringRule
    {
        return FluentRule::string()->required()->regex('/^[a-z]+$/');
    }

    public function n0412(): StringRule
    {
        return FluentRule::string()->max(255)->nullable();
    }

    public function n0413(): StringRule
    {
        return FluentRule::string()->min(8)->max(72);
    }

    public function n0414(): StringRule
    {
        return FluentRule::string()->min(1)->max(100);
    }

    public function n0415(): StringRule
    {
        return FluentRule::string()->alphaDash()->max(50);
    }

    public function n0416(): StringRule
    {
        return FluentRule::string()->startsWith('prefix')->required();
    }

    public function n0417(): StringRule
    {
        return FluentRule::string()->endsWith('.com')->nullable();
    }

    public function n0418(): StringRule
    {
        return FluentRule::string()->date()->required();
    }

    public function n0419(): StringRule
    {
        return FluentRule::string()->json()->nullable();
    }

    public function n0420(): StringRule
    {
        return FluentRule::string()->timezone()->required();
    }

    public function n0421(): StringRule
    {
        return FluentRule::string()->lowercase()->max(100);
    }

    public function n0422(): StringRule
    {
        return FluentRule::string()->uppercase()->max(100);
    }

    public function n0423(): StringRule
    {
        return FluentRule::string()->ascii()->required();
    }

    public function n0424(): StringRule
    {
        return FluentRule::string()->hexColor()->nullable();
    }

    public function n0425(): StringRule
    {
        return FluentRule::string()->macAddress()->required();
    }

    public function n0426(): StringRule
    {
        return FluentRule::string()->ip()->required();
    }

    public function n0427(): StringRule
    {
        return FluentRule::string()->ipv4()->nullable();
    }

    public function n0428(): StringRule
    {
        return FluentRule::string()->ipv6()->required();
    }

    public function n0429(): StringRule
    {
        return FluentRule::string()->ulid()->required();
    }

    public function n0430(): StringRule
    {
        return FluentRule::string()->between(2, 100)->required();
    }

    public function n0431(): StringRule
    {
        return FluentRule::string()->exactly(10)->required();
    }

    public function n0432(): StringRule
    {
        return FluentRule::string()->regex('/\d+/')->nullable();
    }

    public function n0433(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }

    public function n0434(): StringRule
    {
        return FluentRule::string()->email()->nullable();
    }

    public function n0435(): StringRule
    {
        return FluentRule::string()->url()->required();
    }

    public function n0436(): StringRule
    {
        return FluentRule::string()->alpha()->max(50);
    }

    public function n0437(): StringRule
    {
        return FluentRule::string()->uuid()->required();
    }

    public function n0438(): StringRule
    {
        return FluentRule::string()->required()->regex('/^[a-z]+$/');
    }

    public function n0439(): StringRule
    {
        return FluentRule::string()->max(255)->nullable();
    }

    public function n0440(): StringRule
    {
        return FluentRule::string()->min(8)->max(72);
    }

    public function n0441(): StringRule
    {
        return FluentRule::string()->min(1)->max(100);
    }

    public function n0442(): StringRule
    {
        return FluentRule::string()->alphaDash()->max(50);
    }

    public function n0443(): StringRule
    {
        return FluentRule::string()->startsWith('prefix')->required();
    }

    public function n0444(): StringRule
    {
        return FluentRule::string()->endsWith('.com')->nullable();
    }

    public function n0445(): StringRule
    {
        return FluentRule::string()->date()->required();
    }

    public function n0446(): StringRule
    {
        return FluentRule::string()->json()->nullable();
    }

    public function n0447(): StringRule
    {
        return FluentRule::string()->timezone()->required();
    }

    public function n0448(): StringRule
    {
        return FluentRule::string()->lowercase()->max(100);
    }

    public function n0449(): StringRule
    {
        return FluentRule::string()->uppercase()->max(100);
    }

    public function n0450(): StringRule
    {
        return FluentRule::string()->ascii()->required();
    }

    public function n0451(): StringRule
    {
        return FluentRule::string()->hexColor()->nullable();
    }

    public function n0452(): StringRule
    {
        return FluentRule::string()->macAddress()->required();
    }

    public function n0453(): StringRule
    {
        return FluentRule::string()->ip()->required();
    }

    public function n0454(): StringRule
    {
        return FluentRule::string()->ipv4()->nullable();
    }

    public function n0455(): StringRule
    {
        return FluentRule::string()->ipv6()->required();
    }

    public function n0456(): StringRule
    {
        return FluentRule::string()->ulid()->required();
    }

    public function n0457(): StringRule
    {
        return FluentRule::string()->between(2, 100)->required();
    }

    public function n0458(): StringRule
    {
        return FluentRule::string()->exactly(10)->required();
    }

    public function n0459(): StringRule
    {
        return FluentRule::string()->regex('/\d+/')->nullable();
    }

    public function n0460(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }

    public function n0461(): StringRule
    {
        return FluentRule::string()->email()->nullable();
    }

    public function n0462(): StringRule
    {
        return FluentRule::string()->url()->required();
    }

    public function n0463(): StringRule
    {
        return FluentRule::string()->alpha()->max(50);
    }

    public function n0464(): StringRule
    {
        return FluentRule::string()->uuid()->required();
    }

    public function n0465(): StringRule
    {
        return FluentRule::string()->required()->regex('/^[a-z]+$/');
    }

    public function n0466(): StringRule
    {
        return FluentRule::string()->max(255)->nullable();
    }

    public function n0467(): StringRule
    {
        return FluentRule::string()->min(8)->max(72);
    }

    public function n0468(): StringRule
    {
        return FluentRule::string()->min(1)->max(100);
    }

    public function n0469(): StringRule
    {
        return FluentRule::string()->alphaDash()->max(50);
    }

    public function n0470(): StringRule
    {
        return FluentRule::string()->startsWith('prefix')->required();
    }

    public function n0471(): StringRule
    {
        return FluentRule::string()->endsWith('.com')->nullable();
    }

    public function n0472(): StringRule
    {
        return FluentRule::string()->date()->required();
    }

    public function n0473(): StringRule
    {
        return FluentRule::string()->json()->nullable();
    }

    public function n0474(): StringRule
    {
        return FluentRule::string()->timezone()->required();
    }

    public function n0475(): StringRule
    {
        return FluentRule::string()->lowercase()->max(100);
    }

    public function n0476(): StringRule
    {
        return FluentRule::string()->uppercase()->max(100);
    }

    public function n0477(): StringRule
    {
        return FluentRule::string()->ascii()->required();
    }

    public function n0478(): StringRule
    {
        return FluentRule::string()->hexColor()->nullable();
    }

    public function n0479(): StringRule
    {
        return FluentRule::string()->macAddress()->required();
    }

    public function n0480(): StringRule
    {
        return FluentRule::string()->ip()->required();
    }

    public function n0481(): StringRule
    {
        return FluentRule::string()->ipv4()->nullable();
    }

    public function n0482(): StringRule
    {
        return FluentRule::string()->ipv6()->required();
    }

    public function n0483(): StringRule
    {
        return FluentRule::string()->ulid()->required();
    }

    public function n0484(): StringRule
    {
        return FluentRule::string()->between(2, 100)->required();
    }

    public function n0485(): StringRule
    {
        return FluentRule::string()->exactly(10)->required();
    }

    public function n0486(): StringRule
    {
        return FluentRule::string()->regex('/\d+/')->nullable();
    }

    public function n0487(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }

    public function n0488(): StringRule
    {
        return FluentRule::string()->email()->nullable();
    }

    public function n0489(): StringRule
    {
        return FluentRule::string()->url()->required();
    }

    public function n0490(): StringRule
    {
        return FluentRule::string()->alpha()->max(50);
    }

    public function n0491(): StringRule
    {
        return FluentRule::string()->uuid()->required();
    }

    public function n0492(): StringRule
    {
        return FluentRule::string()->required()->regex('/^[a-z]+$/');
    }

    public function n0493(): StringRule
    {
        return FluentRule::string()->max(255)->nullable();
    }

    public function n0494(): StringRule
    {
        return FluentRule::string()->min(8)->max(72);
    }

    public function n0495(): StringRule
    {
        return FluentRule::string()->min(1)->max(100);
    }

    public function n0496(): StringRule
    {
        return FluentRule::string()->alphaDash()->max(50);
    }

    public function n0497(): StringRule
    {
        return FluentRule::string()->startsWith('prefix')->required();
    }

    public function n0498(): StringRule
    {
        return FluentRule::string()->endsWith('.com')->nullable();
    }

    public function n0499(): StringRule
    {
        return FluentRule::string()->date()->required();
    }

    public function n0500(): StringRule
    {
        return FluentRule::string()->json()->nullable();
    }

    public function n0501(): StringRule
    {
        return FluentRule::string()->timezone()->required();
    }

    public function n0502(): StringRule
    {
        return FluentRule::string()->lowercase()->max(100);
    }

    public function n0503(): StringRule
    {
        return FluentRule::string()->uppercase()->max(100);
    }

    public function n0504(): StringRule
    {
        return FluentRule::string()->ascii()->required();
    }

    public function n0505(): StringRule
    {
        return FluentRule::string()->hexColor()->nullable();
    }

    public function n0506(): StringRule
    {
        return FluentRule::string()->macAddress()->required();
    }

    public function n0507(): StringRule
    {
        return FluentRule::string()->ip()->required();
    }

    public function n0508(): StringRule
    {
        return FluentRule::string()->ipv4()->nullable();
    }

    public function n0509(): StringRule
    {
        return FluentRule::string()->ipv6()->required();
    }

    public function n0510(): StringRule
    {
        return FluentRule::string()->ulid()->required();
    }

    public function n0511(): StringRule
    {
        return FluentRule::string()->between(2, 100)->required();
    }

    public function n0512(): StringRule
    {
        return FluentRule::string()->exactly(10)->required();
    }

    public function n0513(): StringRule
    {
        return FluentRule::string()->regex('/\d+/')->nullable();
    }

    public function n0514(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }

    public function n0515(): StringRule
    {
        return FluentRule::string()->email()->nullable();
    }

    public function n0516(): StringRule
    {
        return FluentRule::string()->url()->required();
    }

    public function n0517(): StringRule
    {
        return FluentRule::string()->alpha()->max(50);
    }

    public function n0518(): StringRule
    {
        return FluentRule::string()->uuid()->required();
    }

    public function n0519(): StringRule
    {
        return FluentRule::string()->required()->regex('/^[a-z]+$/');
    }

    public function n0520(): StringRule
    {
        return FluentRule::string()->max(255)->nullable();
    }

    public function n0521(): StringRule
    {
        return FluentRule::string()->min(8)->max(72);
    }

    public function n0522(): StringRule
    {
        return FluentRule::string()->min(1)->max(100);
    }

    public function n0523(): StringRule
    {
        return FluentRule::string()->alphaDash()->max(50);
    }

    public function n0524(): StringRule
    {
        return FluentRule::string()->startsWith('prefix')->required();
    }

    public function n0525(): StringRule
    {
        return FluentRule::string()->endsWith('.com')->nullable();
    }

    public function n0526(): StringRule
    {
        return FluentRule::string()->date()->required();
    }

    public function n0527(): StringRule
    {
        return FluentRule::string()->json()->nullable();
    }

    public function n0528(): StringRule
    {
        return FluentRule::string()->timezone()->required();
    }

    public function n0529(): StringRule
    {
        return FluentRule::string()->lowercase()->max(100);
    }

    public function n0530(): StringRule
    {
        return FluentRule::string()->uppercase()->max(100);
    }

    public function n0531(): StringRule
    {
        return FluentRule::string()->ascii()->required();
    }

    public function n0532(): StringRule
    {
        return FluentRule::string()->hexColor()->nullable();
    }

    public function n0533(): StringRule
    {
        return FluentRule::string()->macAddress()->required();
    }

    public function n0534(): StringRule
    {
        return FluentRule::string()->ip()->required();
    }

    public function n0535(): StringRule
    {
        return FluentRule::string()->ipv4()->nullable();
    }

    public function n0536(): StringRule
    {
        return FluentRule::string()->ipv6()->required();
    }

    public function n0537(): StringRule
    {
        return FluentRule::string()->ulid()->required();
    }

    public function n0538(): StringRule
    {
        return FluentRule::string()->between(2, 100)->required();
    }

    public function n0539(): StringRule
    {
        return FluentRule::string()->exactly(10)->required();
    }

    public function n0540(): StringRule
    {
        return FluentRule::string()->regex('/\d+/')->nullable();
    }

    public function n0541(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }

    public function n0542(): StringRule
    {
        return FluentRule::string()->email()->nullable();
    }

    public function n0543(): StringRule
    {
        return FluentRule::string()->url()->required();
    }

    public function n0544(): StringRule
    {
        return FluentRule::string()->alpha()->max(50);
    }

    public function n0545(): StringRule
    {
        return FluentRule::string()->uuid()->required();
    }

    public function n0546(): StringRule
    {
        return FluentRule::string()->required()->regex('/^[a-z]+$/');
    }

    public function n0547(): StringRule
    {
        return FluentRule::string()->max(255)->nullable();
    }

    public function n0548(): StringRule
    {
        return FluentRule::string()->min(8)->max(72);
    }

    public function n0549(): StringRule
    {
        return FluentRule::string()->min(1)->max(100);
    }

    public function n0550(): StringRule
    {
        return FluentRule::string()->alphaDash()->max(50);
    }

    public function n0551(): StringRule
    {
        return FluentRule::string()->startsWith('prefix')->required();
    }

    public function n0552(): StringRule
    {
        return FluentRule::string()->endsWith('.com')->nullable();
    }

    public function n0553(): StringRule
    {
        return FluentRule::string()->date()->required();
    }

    public function n0554(): StringRule
    {
        return FluentRule::string()->json()->nullable();
    }

    public function n0555(): StringRule
    {
        return FluentRule::string()->timezone()->required();
    }

    public function n0556(): StringRule
    {
        return FluentRule::string()->lowercase()->max(100);
    }

    public function n0557(): StringRule
    {
        return FluentRule::string()->uppercase()->max(100);
    }

    public function n0558(): StringRule
    {
        return FluentRule::string()->ascii()->required();
    }

    public function n0559(): StringRule
    {
        return FluentRule::string()->hexColor()->nullable();
    }

    public function n0560(): StringRule
    {
        return FluentRule::string()->macAddress()->required();
    }

    public function n0561(): StringRule
    {
        return FluentRule::string()->ip()->required();
    }

    public function n0562(): StringRule
    {
        return FluentRule::string()->ipv4()->nullable();
    }

    public function n0563(): StringRule
    {
        return FluentRule::string()->ipv6()->required();
    }

    public function n0564(): StringRule
    {
        return FluentRule::string()->ulid()->required();
    }

    public function n0565(): StringRule
    {
        return FluentRule::string()->between(2, 100)->required();
    }

    public function n0566(): StringRule
    {
        return FluentRule::string()->exactly(10)->required();
    }

    public function n0567(): StringRule
    {
        return FluentRule::string()->regex('/\d+/')->nullable();
    }

    public function n0568(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }

    public function n0569(): StringRule
    {
        return FluentRule::string()->email()->nullable();
    }

    public function n0570(): StringRule
    {
        return FluentRule::string()->url()->required();
    }

    public function n0571(): StringRule
    {
        return FluentRule::string()->alpha()->max(50);
    }

    public function n0572(): StringRule
    {
        return FluentRule::string()->uuid()->required();
    }

    public function n0573(): StringRule
    {
        return FluentRule::string()->required()->regex('/^[a-z]+$/');
    }

    public function n0574(): StringRule
    {
        return FluentRule::string()->max(255)->nullable();
    }

    public function n0575(): StringRule
    {
        return FluentRule::string()->min(8)->max(72);
    }

    public function n0576(): StringRule
    {
        return FluentRule::string()->min(1)->max(100);
    }

    public function n0577(): StringRule
    {
        return FluentRule::string()->alphaDash()->max(50);
    }

    public function n0578(): StringRule
    {
        return FluentRule::string()->startsWith('prefix')->required();
    }

    public function n0579(): StringRule
    {
        return FluentRule::string()->endsWith('.com')->nullable();
    }

    public function n0580(): StringRule
    {
        return FluentRule::string()->date()->required();
    }

    public function n0581(): StringRule
    {
        return FluentRule::string()->json()->nullable();
    }

    public function n0582(): StringRule
    {
        return FluentRule::string()->timezone()->required();
    }

    public function n0583(): StringRule
    {
        return FluentRule::string()->lowercase()->max(100);
    }

    public function n0584(): StringRule
    {
        return FluentRule::string()->uppercase()->max(100);
    }

    public function n0585(): StringRule
    {
        return FluentRule::string()->ascii()->required();
    }

    public function n0586(): StringRule
    {
        return FluentRule::string()->hexColor()->nullable();
    }

    public function n0587(): StringRule
    {
        return FluentRule::string()->macAddress()->required();
    }

    public function n0588(): StringRule
    {
        return FluentRule::string()->ip()->required();
    }

    public function n0589(): StringRule
    {
        return FluentRule::string()->ipv4()->nullable();
    }

    public function n0590(): StringRule
    {
        return FluentRule::string()->ipv6()->required();
    }

    public function n0591(): StringRule
    {
        return FluentRule::string()->ulid()->required();
    }

    public function n0592(): StringRule
    {
        return FluentRule::string()->between(2, 100)->required();
    }

    public function n0593(): StringRule
    {
        return FluentRule::string()->exactly(10)->required();
    }

    public function n0594(): StringRule
    {
        return FluentRule::string()->regex('/\d+/')->nullable();
    }

    public function n0595(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }

    public function n0596(): StringRule
    {
        return FluentRule::string()->email()->nullable();
    }

    public function n0597(): StringRule
    {
        return FluentRule::string()->url()->required();
    }

    public function n0598(): StringRule
    {
        return FluentRule::string()->alpha()->max(50);
    }

    public function n0599(): StringRule
    {
        return FluentRule::string()->uuid()->required();
    }

    public function n0600(): StringRule
    {
        return FluentRule::string()->required()->regex('/^[a-z]+$/');
    }

    public function n0601(): StringRule
    {
        return FluentRule::string()->max(255)->nullable();
    }

    public function n0602(): StringRule
    {
        return FluentRule::string()->min(8)->max(72);
    }

    public function n0603(): StringRule
    {
        return FluentRule::string()->min(1)->max(100);
    }

    public function n0604(): StringRule
    {
        return FluentRule::string()->alphaDash()->max(50);
    }

    public function n0605(): StringRule
    {
        return FluentRule::string()->startsWith('prefix')->required();
    }

    public function n0606(): StringRule
    {
        return FluentRule::string()->endsWith('.com')->nullable();
    }

    public function n0607(): StringRule
    {
        return FluentRule::string()->date()->required();
    }

    public function n0608(): StringRule
    {
        return FluentRule::string()->json()->nullable();
    }

    public function n0609(): StringRule
    {
        return FluentRule::string()->timezone()->required();
    }

    public function n0610(): StringRule
    {
        return FluentRule::string()->lowercase()->max(100);
    }

    public function n0611(): StringRule
    {
        return FluentRule::string()->uppercase()->max(100);
    }

    public function n0612(): StringRule
    {
        return FluentRule::string()->ascii()->required();
    }

    public function n0613(): StringRule
    {
        return FluentRule::string()->hexColor()->nullable();
    }

    public function n0614(): StringRule
    {
        return FluentRule::string()->macAddress()->required();
    }

    public function n0615(): StringRule
    {
        return FluentRule::string()->ip()->required();
    }

    public function n0616(): StringRule
    {
        return FluentRule::string()->ipv4()->nullable();
    }

    public function n0617(): StringRule
    {
        return FluentRule::string()->ipv6()->required();
    }

    public function n0618(): StringRule
    {
        return FluentRule::string()->ulid()->required();
    }

    public function n0619(): StringRule
    {
        return FluentRule::string()->between(2, 100)->required();
    }

    public function n0620(): StringRule
    {
        return FluentRule::string()->exactly(10)->required();
    }

    public function n0621(): StringRule
    {
        return FluentRule::string()->regex('/\d+/')->nullable();
    }

    public function n0622(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }

    public function n0623(): StringRule
    {
        return FluentRule::string()->email()->nullable();
    }

    public function n0624(): StringRule
    {
        return FluentRule::string()->url()->required();
    }

    public function n0625(): StringRule
    {
        return FluentRule::string()->alpha()->max(50);
    }

    public function n0626(): StringRule
    {
        return FluentRule::string()->uuid()->required();
    }

    public function n0627(): StringRule
    {
        return FluentRule::string()->required()->regex('/^[a-z]+$/');
    }

    public function n0628(): StringRule
    {
        return FluentRule::string()->max(255)->nullable();
    }

    public function n0629(): StringRule
    {
        return FluentRule::string()->min(8)->max(72);
    }

    public function n0630(): StringRule
    {
        return FluentRule::string()->min(1)->max(100);
    }

    public function n0631(): StringRule
    {
        return FluentRule::string()->alphaDash()->max(50);
    }

    public function n0632(): StringRule
    {
        return FluentRule::string()->startsWith('prefix')->required();
    }

    public function n0633(): StringRule
    {
        return FluentRule::string()->endsWith('.com')->nullable();
    }

    public function n0634(): StringRule
    {
        return FluentRule::string()->date()->required();
    }

    public function n0635(): StringRule
    {
        return FluentRule::string()->json()->nullable();
    }

    public function n0636(): StringRule
    {
        return FluentRule::string()->timezone()->required();
    }

    public function n0637(): StringRule
    {
        return FluentRule::string()->lowercase()->max(100);
    }

    public function n0638(): StringRule
    {
        return FluentRule::string()->uppercase()->max(100);
    }

    public function n0639(): StringRule
    {
        return FluentRule::string()->ascii()->required();
    }

    public function n0640(): StringRule
    {
        return FluentRule::string()->hexColor()->nullable();
    }

    public function n0641(): StringRule
    {
        return FluentRule::string()->macAddress()->required();
    }

    public function n0642(): StringRule
    {
        return FluentRule::string()->ip()->required();
    }

    public function n0643(): StringRule
    {
        return FluentRule::string()->ipv4()->nullable();
    }

    public function n0644(): StringRule
    {
        return FluentRule::string()->ipv6()->required();
    }

    public function n0645(): StringRule
    {
        return FluentRule::string()->ulid()->required();
    }

    public function n0646(): StringRule
    {
        return FluentRule::string()->between(2, 100)->required();
    }

    public function n0647(): StringRule
    {
        return FluentRule::string()->exactly(10)->required();
    }

    public function n0648(): StringRule
    {
        return FluentRule::string()->regex('/\d+/')->nullable();
    }

    public function n0649(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }

    public function n0650(): StringRule
    {
        return FluentRule::string()->email()->nullable();
    }

    public function n0651(): StringRule
    {
        return FluentRule::string()->url()->required();
    }

    public function n0652(): StringRule
    {
        return FluentRule::string()->alpha()->max(50);
    }

    public function n0653(): StringRule
    {
        return FluentRule::string()->uuid()->required();
    }

    public function n0654(): StringRule
    {
        return FluentRule::string()->required()->regex('/^[a-z]+$/');
    }

    public function n0655(): StringRule
    {
        return FluentRule::string()->max(255)->nullable();
    }

    public function n0656(): StringRule
    {
        return FluentRule::string()->min(8)->max(72);
    }

    public function n0657(): StringRule
    {
        return FluentRule::string()->min(1)->max(100);
    }

    public function n0658(): StringRule
    {
        return FluentRule::string()->alphaDash()->max(50);
    }

    public function n0659(): StringRule
    {
        return FluentRule::string()->startsWith('prefix')->required();
    }

    public function n0660(): StringRule
    {
        return FluentRule::string()->endsWith('.com')->nullable();
    }

    public function n0661(): StringRule
    {
        return FluentRule::string()->date()->required();
    }

    public function n0662(): StringRule
    {
        return FluentRule::string()->json()->nullable();
    }

    public function n0663(): StringRule
    {
        return FluentRule::string()->timezone()->required();
    }

    public function n0664(): StringRule
    {
        return FluentRule::string()->lowercase()->max(100);
    }

    public function n0665(): StringRule
    {
        return FluentRule::string()->uppercase()->max(100);
    }

    public function n0666(): StringRule
    {
        return FluentRule::string()->ascii()->required();
    }

    public function n0667(): StringRule
    {
        return FluentRule::string()->hexColor()->nullable();
    }

    public function n0668(): StringRule
    {
        return FluentRule::string()->macAddress()->required();
    }

    public function n0669(): StringRule
    {
        return FluentRule::string()->ip()->required();
    }

    public function n0670(): StringRule
    {
        return FluentRule::string()->ipv4()->nullable();
    }

    public function n0671(): StringRule
    {
        return FluentRule::string()->ipv6()->required();
    }

    public function n0672(): StringRule
    {
        return FluentRule::string()->ulid()->required();
    }

    public function n0673(): StringRule
    {
        return FluentRule::string()->between(2, 100)->required();
    }

    public function n0674(): StringRule
    {
        return FluentRule::string()->exactly(10)->required();
    }

    public function n0675(): StringRule
    {
        return FluentRule::string()->regex('/\d+/')->nullable();
    }

    public function n0676(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }

    public function n0677(): StringRule
    {
        return FluentRule::string()->email()->nullable();
    }

    public function n0678(): StringRule
    {
        return FluentRule::string()->url()->required();
    }

    public function n0679(): StringRule
    {
        return FluentRule::string()->alpha()->max(50);
    }

    public function n0680(): StringRule
    {
        return FluentRule::string()->uuid()->required();
    }

    public function n0681(): StringRule
    {
        return FluentRule::string()->required()->regex('/^[a-z]+$/');
    }

    public function n0682(): StringRule
    {
        return FluentRule::string()->max(255)->nullable();
    }

    public function n0683(): StringRule
    {
        return FluentRule::string()->min(8)->max(72);
    }

    public function n0684(): StringRule
    {
        return FluentRule::string()->min(1)->max(100);
    }

    public function n0685(): StringRule
    {
        return FluentRule::string()->alphaDash()->max(50);
    }

    public function n0686(): StringRule
    {
        return FluentRule::string()->startsWith('prefix')->required();
    }

    public function n0687(): StringRule
    {
        return FluentRule::string()->endsWith('.com')->nullable();
    }

    public function n0688(): StringRule
    {
        return FluentRule::string()->date()->required();
    }

    public function n0689(): StringRule
    {
        return FluentRule::string()->json()->nullable();
    }

    public function n0690(): StringRule
    {
        return FluentRule::string()->timezone()->required();
    }

    public function n0691(): StringRule
    {
        return FluentRule::string()->lowercase()->max(100);
    }

    public function n0692(): StringRule
    {
        return FluentRule::string()->uppercase()->max(100);
    }

    public function n0693(): StringRule
    {
        return FluentRule::string()->ascii()->required();
    }

    public function n0694(): StringRule
    {
        return FluentRule::string()->hexColor()->nullable();
    }

    public function n0695(): StringRule
    {
        return FluentRule::string()->macAddress()->required();
    }

    public function n0696(): StringRule
    {
        return FluentRule::string()->ip()->required();
    }

    public function n0697(): StringRule
    {
        return FluentRule::string()->ipv4()->nullable();
    }

    public function n0698(): StringRule
    {
        return FluentRule::string()->ipv6()->required();
    }

    public function n0699(): StringRule
    {
        return FluentRule::string()->ulid()->required();
    }

    public function n0700(): StringRule
    {
        return FluentRule::string()->between(2, 100)->required();
    }

    public function n0701(): StringRule
    {
        return FluentRule::string()->exactly(10)->required();
    }

    public function n0702(): StringRule
    {
        return FluentRule::string()->regex('/\d+/')->nullable();
    }

    public function n0703(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }

    public function n0704(): StringRule
    {
        return FluentRule::string()->email()->nullable();
    }

    public function n0705(): StringRule
    {
        return FluentRule::string()->url()->required();
    }

    public function n0706(): StringRule
    {
        return FluentRule::string()->alpha()->max(50);
    }

    public function n0707(): StringRule
    {
        return FluentRule::string()->uuid()->required();
    }

    public function n0708(): StringRule
    {
        return FluentRule::string()->required()->regex('/^[a-z]+$/');
    }

    public function n0709(): StringRule
    {
        return FluentRule::string()->max(255)->nullable();
    }

    public function n0710(): StringRule
    {
        return FluentRule::string()->min(8)->max(72);
    }

    public function n0711(): StringRule
    {
        return FluentRule::string()->min(1)->max(100);
    }

    public function n0712(): StringRule
    {
        return FluentRule::string()->alphaDash()->max(50);
    }

    public function n0713(): StringRule
    {
        return FluentRule::string()->startsWith('prefix')->required();
    }

    public function n0714(): StringRule
    {
        return FluentRule::string()->endsWith('.com')->nullable();
    }

    public function n0715(): StringRule
    {
        return FluentRule::string()->date()->required();
    }

    public function n0716(): StringRule
    {
        return FluentRule::string()->json()->nullable();
    }

    public function n0717(): StringRule
    {
        return FluentRule::string()->timezone()->required();
    }

    public function n0718(): StringRule
    {
        return FluentRule::string()->lowercase()->max(100);
    }

    public function n0719(): StringRule
    {
        return FluentRule::string()->uppercase()->max(100);
    }

    public function n0720(): StringRule
    {
        return FluentRule::string()->ascii()->required();
    }

    public function n0721(): StringRule
    {
        return FluentRule::string()->hexColor()->nullable();
    }

    public function n0722(): StringRule
    {
        return FluentRule::string()->macAddress()->required();
    }

    public function n0723(): StringRule
    {
        return FluentRule::string()->ip()->required();
    }

    public function n0724(): StringRule
    {
        return FluentRule::string()->ipv4()->nullable();
    }

    public function n0725(): StringRule
    {
        return FluentRule::string()->ipv6()->required();
    }

    public function n0726(): StringRule
    {
        return FluentRule::string()->ulid()->required();
    }

    public function n0727(): StringRule
    {
        return FluentRule::string()->between(2, 100)->required();
    }

    public function n0728(): StringRule
    {
        return FluentRule::string()->exactly(10)->required();
    }

    public function n0729(): StringRule
    {
        return FluentRule::string()->regex('/\d+/')->nullable();
    }

    public function n0730(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }

    public function n0731(): StringRule
    {
        return FluentRule::string()->email()->nullable();
    }

    public function n0732(): StringRule
    {
        return FluentRule::string()->url()->required();
    }

    public function n0733(): StringRule
    {
        return FluentRule::string()->alpha()->max(50);
    }

    public function n0734(): StringRule
    {
        return FluentRule::string()->uuid()->required();
    }

    public function n0735(): StringRule
    {
        return FluentRule::string()->required()->regex('/^[a-z]+$/');
    }

    public function n0736(): StringRule
    {
        return FluentRule::string()->max(255)->nullable();
    }

    public function n0737(): StringRule
    {
        return FluentRule::string()->min(8)->max(72);
    }

    public function n0738(): StringRule
    {
        return FluentRule::string()->min(1)->max(100);
    }

    public function n0739(): StringRule
    {
        return FluentRule::string()->alphaDash()->max(50);
    }

    public function n0740(): StringRule
    {
        return FluentRule::string()->startsWith('prefix')->required();
    }

    public function n0741(): StringRule
    {
        return FluentRule::string()->endsWith('.com')->nullable();
    }

    public function n0742(): StringRule
    {
        return FluentRule::string()->date()->required();
    }

    public function n0743(): StringRule
    {
        return FluentRule::string()->json()->nullable();
    }

    public function n0744(): StringRule
    {
        return FluentRule::string()->timezone()->required();
    }

    public function n0745(): StringRule
    {
        return FluentRule::string()->lowercase()->max(100);
    }

    public function n0746(): StringRule
    {
        return FluentRule::string()->uppercase()->max(100);
    }

    public function n0747(): StringRule
    {
        return FluentRule::string()->ascii()->required();
    }

    public function n0748(): StringRule
    {
        return FluentRule::string()->hexColor()->nullable();
    }

    public function n0749(): StringRule
    {
        return FluentRule::string()->macAddress()->required();
    }

    public function n0750(): StringRule
    {
        return FluentRule::string()->ip()->required();
    }

    public function n0751(): StringRule
    {
        return FluentRule::string()->ipv4()->nullable();
    }

    public function n0752(): StringRule
    {
        return FluentRule::string()->ipv6()->required();
    }

    public function n0753(): StringRule
    {
        return FluentRule::string()->ulid()->required();
    }

    public function n0754(): StringRule
    {
        return FluentRule::string()->between(2, 100)->required();
    }

    public function n0755(): StringRule
    {
        return FluentRule::string()->exactly(10)->required();
    }

    public function n0756(): StringRule
    {
        return FluentRule::string()->regex('/\d+/')->nullable();
    }

    public function n0757(): StringRule
    {
        return FluentRule::string()->required()->min(1)->max(100);
    }

    public function n0758(): StringRule
    {
        return FluentRule::string()->email()->nullable();
    }

    public function n0759(): StringRule
    {
        return FluentRule::string()->url()->required();
    }

    public function n0760(): StringRule
    {
        return FluentRule::string()->alpha()->max(50);
    }

    public function n0761(): StringRule
    {
        return FluentRule::string()->uuid()->required();
    }

    public function n0762(): StringRule
    {
        return FluentRule::string()->required()->regex('/^[a-z]+$/');
    }

    public function n0763(): StringRule
    {
        return FluentRule::string()->max(255)->nullable();
    }

    public function n0764(): StringRule
    {
        return FluentRule::string()->min(8)->max(72);
    }

    public function n0765(): StringRule
    {
        return FluentRule::string()->min(1)->max(100);
    }

    public function n0766(): StringRule
    {
        return FluentRule::string()->alphaDash()->max(50);
    }

    public function n0767(): StringRule
    {
        return FluentRule::string()->startsWith('prefix')->required();
    }

    public function n0768(): StringRule
    {
        return FluentRule::string()->endsWith('.com')->nullable();
    }

    public function n0769(): StringRule
    {
        return FluentRule::string()->date()->required();
    }

    public function n0770(): StringRule
    {
        return FluentRule::string()->json()->nullable();
    }

    public function n0771(): StringRule
    {
        return FluentRule::string()->timezone()->required();
    }

    public function n0772(): StringRule
    {
        return FluentRule::string()->lowercase()->max(100);
    }

    public function n0773(): StringRule
    {
        return FluentRule::string()->uppercase()->max(100);
    }

    public function n0774(): StringRule
    {
        return FluentRule::string()->ascii()->required();
    }

    public function n0775(): StringRule
    {
        return FluentRule::string()->hexColor()->nullable();
    }

    public function n0776(): StringRule
    {
        return FluentRule::string()->macAddress()->required();
    }

    public function n0777(): StringRule
    {
        return FluentRule::string()->ip()->required();
    }

    public function n0778(): StringRule
    {
        return FluentRule::string()->ipv4()->nullable();
    }

    public function n0779(): StringRule
    {
        return FluentRule::string()->ipv6()->required();
    }

    public function n0780(): StringRule
    {
        return FluentRule::string()->ulid()->required();
    }

    public function u0781(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->required());
    }

    public function u0782(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->email());
    }

    public function u0783(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->url());
    }

    public function u0784(): ArrayRule
    {
        return FluentRule::array()->distinct()->each(FluentRule::string());
    }

    public function u0785(): ArrayRule
    {
        return FluentRule::array()->min(1)->each(FluentRule::string());
    }

    public function u0786(): ArrayRule
    {
        return FluentRule::array()->nullable()->each(FluentRule::string());
    }

    public function u0787(): ArrayRule
    {
        return FluentRule::list()->each(FluentRule::string()->required());
    }

    public function u0788(): ArrayRule
    {
        return FluentRule::list()->each(FluentRule::string()->min(1)->max(50));
    }

    public function u0789(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->required());
    }

    public function u0790(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->email());
    }

    public function u0791(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->url());
    }

    public function u0792(): ArrayRule
    {
        return FluentRule::array()->distinct()->each(FluentRule::string());
    }

    public function u0793(): ArrayRule
    {
        return FluentRule::array()->min(1)->each(FluentRule::string());
    }

    public function u0794(): ArrayRule
    {
        return FluentRule::array()->nullable()->each(FluentRule::string());
    }

    public function u0795(): ArrayRule
    {
        return FluentRule::list()->each(FluentRule::string()->required());
    }

    public function u0796(): ArrayRule
    {
        return FluentRule::list()->each(FluentRule::string()->min(1)->max(50));
    }

    public function u0797(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->required());
    }

    public function u0798(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->email());
    }

    public function u0799(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->url());
    }

    public function u0800(): ArrayRule
    {
        return FluentRule::array()->distinct()->each(FluentRule::string());
    }

    public function u0801(): ArrayRule
    {
        return FluentRule::array()->min(1)->each(FluentRule::string());
    }

    public function u0802(): ArrayRule
    {
        return FluentRule::array()->nullable()->each(FluentRule::string());
    }

    public function u0803(): ArrayRule
    {
        return FluentRule::list()->each(FluentRule::string()->required());
    }

    public function u0804(): ArrayRule
    {
        return FluentRule::list()->each(FluentRule::string()->min(1)->max(50));
    }

    public function u0805(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->required());
    }

    public function u0806(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->email());
    }

    public function u0807(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->url());
    }

    public function u0808(): ArrayRule
    {
        return FluentRule::array()->distinct()->each(FluentRule::string());
    }

    public function u0809(): ArrayRule
    {
        return FluentRule::array()->min(1)->each(FluentRule::string());
    }

    public function u0810(): ArrayRule
    {
        return FluentRule::array()->nullable()->each(FluentRule::string());
    }

    public function u0811(): ArrayRule
    {
        return FluentRule::list()->each(FluentRule::string()->required());
    }

    public function u0812(): ArrayRule
    {
        return FluentRule::list()->each(FluentRule::string()->min(1)->max(50));
    }

    public function u0813(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->required());
    }

    public function u0814(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->email());
    }

    public function u0815(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->url());
    }

    public function u0816(): ArrayRule
    {
        return FluentRule::array()->distinct()->each(FluentRule::string());
    }

    public function u0817(): ArrayRule
    {
        return FluentRule::array()->min(1)->each(FluentRule::string());
    }

    public function u0818(): ArrayRule
    {
        return FluentRule::array()->nullable()->each(FluentRule::string());
    }

    public function u0819(): ArrayRule
    {
        return FluentRule::list()->each(FluentRule::string()->required());
    }

    public function u0820(): ArrayRule
    {
        return FluentRule::list()->each(FluentRule::string()->min(1)->max(50));
    }

    public function u0821(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->required());
    }

    public function u0822(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->email());
    }

    public function u0823(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->url());
    }

    public function u0824(): ArrayRule
    {
        return FluentRule::array()->distinct()->each(FluentRule::string());
    }

    public function u0825(): ArrayRule
    {
        return FluentRule::array()->min(1)->each(FluentRule::string());
    }

    public function u0826(): ArrayRule
    {
        return FluentRule::array()->nullable()->each(FluentRule::string());
    }

    public function u0827(): ArrayRule
    {
        return FluentRule::list()->each(FluentRule::string()->required());
    }

    public function u0828(): ArrayRule
    {
        return FluentRule::list()->each(FluentRule::string()->min(1)->max(50));
    }

    public function u0829(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->required());
    }

    public function u0830(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->email());
    }

    public function u0831(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->url());
    }

    public function u0832(): ArrayRule
    {
        return FluentRule::array()->distinct()->each(FluentRule::string());
    }

    public function u0833(): ArrayRule
    {
        return FluentRule::array()->min(1)->each(FluentRule::string());
    }

    public function u0834(): ArrayRule
    {
        return FluentRule::array()->nullable()->each(FluentRule::string());
    }

    public function u0835(): ArrayRule
    {
        return FluentRule::list()->each(FluentRule::string()->required());
    }

    public function u0836(): ArrayRule
    {
        return FluentRule::list()->each(FluentRule::string()->min(1)->max(50));
    }

    public function u0837(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->required());
    }

    public function u0838(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->email());
    }

    public function u0839(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->url());
    }

    public function u0840(): ArrayRule
    {
        return FluentRule::array()->distinct()->each(FluentRule::string());
    }

    public function u0841(): ArrayRule
    {
        return FluentRule::array()->min(1)->each(FluentRule::string());
    }

    public function u0842(): ArrayRule
    {
        return FluentRule::array()->nullable()->each(FluentRule::string());
    }

    public function u0843(): ArrayRule
    {
        return FluentRule::list()->each(FluentRule::string()->required());
    }

    public function u0844(): ArrayRule
    {
        return FluentRule::list()->each(FluentRule::string()->min(1)->max(50));
    }

    public function u0845(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->required());
    }

    public function u0846(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->email());
    }

    public function u0847(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->url());
    }

    public function u0848(): ArrayRule
    {
        return FluentRule::array()->distinct()->each(FluentRule::string());
    }

    public function u0849(): ArrayRule
    {
        return FluentRule::array()->min(1)->each(FluentRule::string());
    }

    public function u0850(): ArrayRule
    {
        return FluentRule::array()->nullable()->each(FluentRule::string());
    }

    public function u0851(): ArrayRule
    {
        return FluentRule::list()->each(FluentRule::string()->required());
    }

    public function u0852(): ArrayRule
    {
        return FluentRule::list()->each(FluentRule::string()->min(1)->max(50));
    }

    public function u0853(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->required());
    }

    public function u0854(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->email());
    }

    public function u0855(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->url());
    }

    public function u0856(): ArrayRule
    {
        return FluentRule::array()->distinct()->each(FluentRule::string());
    }

    public function u0857(): ArrayRule
    {
        return FluentRule::array()->min(1)->each(FluentRule::string());
    }

    public function u0858(): ArrayRule
    {
        return FluentRule::array()->nullable()->each(FluentRule::string());
    }

    public function u0859(): ArrayRule
    {
        return FluentRule::list()->each(FluentRule::string()->required());
    }

    public function u0860(): ArrayRule
    {
        return FluentRule::list()->each(FluentRule::string()->min(1)->max(50));
    }

    public function u0861(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->required());
    }

    public function u0862(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->email());
    }

    public function u0863(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->url());
    }

    public function u0864(): ArrayRule
    {
        return FluentRule::array()->distinct()->each(FluentRule::string());
    }

    public function u0865(): ArrayRule
    {
        return FluentRule::array()->min(1)->each(FluentRule::string());
    }

    public function u0866(): ArrayRule
    {
        return FluentRule::array()->nullable()->each(FluentRule::string());
    }

    public function u0867(): ArrayRule
    {
        return FluentRule::list()->each(FluentRule::string()->required());
    }

    public function u0868(): ArrayRule
    {
        return FluentRule::list()->each(FluentRule::string()->min(1)->max(50));
    }

    public function u0869(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->required());
    }

    public function u0870(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->email());
    }

    public function u0871(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->url());
    }

    public function u0872(): ArrayRule
    {
        return FluentRule::array()->distinct()->each(FluentRule::string());
    }

    public function u0873(): ArrayRule
    {
        return FluentRule::array()->min(1)->each(FluentRule::string());
    }

    public function u0874(): ArrayRule
    {
        return FluentRule::array()->nullable()->each(FluentRule::string());
    }

    public function u0875(): ArrayRule
    {
        return FluentRule::list()->each(FluentRule::string()->required());
    }

    public function u0876(): ArrayRule
    {
        return FluentRule::list()->each(FluentRule::string()->min(1)->max(50));
    }

    public function u0877(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->required());
    }

    public function u0878(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->email());
    }

    public function u0879(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->url());
    }

    public function u0880(): ArrayRule
    {
        return FluentRule::array()->distinct()->each(FluentRule::string());
    }

    public function u0881(): ArrayRule
    {
        return FluentRule::array()->min(1)->each(FluentRule::string());
    }

    public function u0882(): ArrayRule
    {
        return FluentRule::array()->nullable()->each(FluentRule::string());
    }

    public function u0883(): ArrayRule
    {
        return FluentRule::list()->each(FluentRule::string()->required());
    }

    public function u0884(): ArrayRule
    {
        return FluentRule::list()->each(FluentRule::string()->min(1)->max(50));
    }

    public function u0885(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->required());
    }

    public function u0886(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->email());
    }

    public function u0887(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->url());
    }

    public function u0888(): ArrayRule
    {
        return FluentRule::array()->distinct()->each(FluentRule::string());
    }

    public function u0889(): ArrayRule
    {
        return FluentRule::array()->min(1)->each(FluentRule::string());
    }

    public function u0890(): ArrayRule
    {
        return FluentRule::array()->nullable()->each(FluentRule::string());
    }

    public function u0891(): ArrayRule
    {
        return FluentRule::list()->each(FluentRule::string()->required());
    }

    public function u0892(): ArrayRule
    {
        return FluentRule::list()->each(FluentRule::string()->min(1)->max(50));
    }

    public function u0893(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->required());
    }

    public function u0894(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->email());
    }

    public function u0895(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->url());
    }

    public function u0896(): ArrayRule
    {
        return FluentRule::array()->distinct()->each(FluentRule::string());
    }

    public function u0897(): ArrayRule
    {
        return FluentRule::array()->min(1)->each(FluentRule::string());
    }

    public function u0898(): ArrayRule
    {
        return FluentRule::array()->nullable()->each(FluentRule::string());
    }

    public function u0899(): ArrayRule
    {
        return FluentRule::list()->each(FluentRule::string()->required());
    }

    public function u0900(): ArrayRule
    {
        return FluentRule::list()->each(FluentRule::string()->min(1)->max(50));
    }

    public function b0901(): ArrayRule
    {
        return FluentRule::array()->max(10)->each(FluentRule::string());
    }

    public function b0902(): ArrayRule
    {
        return FluentRule::array()->between(1, 5)->each(FluentRule::string());
    }

    public function b0903(): ArrayRule
    {
        return FluentRule::array()->exactly(3)->each(FluentRule::string());
    }

    public function b0904(): ArrayRule
    {
        return FluentRule::array(['a', 'b', 'c'])->each(FluentRule::string());
    }

    public function b0905(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string())->max(10);
    }

    public function b0906(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string())->between(1, 5);
    }

    public function b0907(): ArrayRule
    {
        return FluentRule::array()->rule('max:10')->each(FluentRule::string());
    }

    public function b0908(): ArrayRule
    {
        return FluentRule::list()->max(5)->each(FluentRule::string()->min(1));
    }

    public function b0909(): ArrayRule
    {
        return FluentRule::array()->max(10)->each(FluentRule::string());
    }

    public function b0910(): ArrayRule
    {
        return FluentRule::array()->between(1, 5)->each(FluentRule::string());
    }

    public function b0911(): ArrayRule
    {
        return FluentRule::array()->exactly(3)->each(FluentRule::string());
    }

    public function b0912(): ArrayRule
    {
        return FluentRule::array(['a', 'b', 'c'])->each(FluentRule::string());
    }

    public function b0913(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string())->max(10);
    }

    public function b0914(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string())->between(1, 5);
    }

    public function b0915(): ArrayRule
    {
        return FluentRule::array()->rule('max:10')->each(FluentRule::string());
    }

    public function b0916(): ArrayRule
    {
        return FluentRule::list()->max(5)->each(FluentRule::string()->min(1));
    }

    public function b0917(): ArrayRule
    {
        return FluentRule::array()->max(10)->each(FluentRule::string());
    }

    public function b0918(): ArrayRule
    {
        return FluentRule::array()->between(1, 5)->each(FluentRule::string());
    }

    public function b0919(): ArrayRule
    {
        return FluentRule::array()->exactly(3)->each(FluentRule::string());
    }

    public function b0920(): ArrayRule
    {
        return FluentRule::array(['a', 'b', 'c'])->each(FluentRule::string());
    }

    public function b0921(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string())->max(10);
    }

    public function b0922(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string())->between(1, 5);
    }

    public function b0923(): ArrayRule
    {
        return FluentRule::array()->rule('max:10')->each(FluentRule::string());
    }

    public function b0924(): ArrayRule
    {
        return FluentRule::list()->max(5)->each(FluentRule::string()->min(1));
    }

    public function b0925(): ArrayRule
    {
        return FluentRule::array()->max(10)->each(FluentRule::string());
    }

    public function b0926(): ArrayRule
    {
        return FluentRule::array()->between(1, 5)->each(FluentRule::string());
    }

    public function b0927(): ArrayRule
    {
        return FluentRule::array()->exactly(3)->each(FluentRule::string());
    }

    public function b0928(): ArrayRule
    {
        return FluentRule::array(['a', 'b', 'c'])->each(FluentRule::string());
    }

    public function b0929(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string())->max(10);
    }

    public function b0930(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string())->between(1, 5);
    }

    public function b0931(): ArrayRule
    {
        return FluentRule::array()->rule('max:10')->each(FluentRule::string());
    }

    public function b0932(): ArrayRule
    {
        return FluentRule::list()->max(5)->each(FluentRule::string()->min(1));
    }

    public function b0933(): ArrayRule
    {
        return FluentRule::array()->max(10)->each(FluentRule::string());
    }

    public function b0934(): ArrayRule
    {
        return FluentRule::array()->between(1, 5)->each(FluentRule::string());
    }

    public function b0935(): ArrayRule
    {
        return FluentRule::array()->exactly(3)->each(FluentRule::string());
    }

    public function b0936(): ArrayRule
    {
        return FluentRule::array(['a', 'b', 'c'])->each(FluentRule::string());
    }

    public function b0937(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string())->max(10);
    }

    public function b0938(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string())->between(1, 5);
    }

    public function b0939(): ArrayRule
    {
        return FluentRule::array()->rule('max:10')->each(FluentRule::string());
    }

    public function b0940(): ArrayRule
    {
        return FluentRule::list()->max(5)->each(FluentRule::string()->min(1));
    }

    public function b0941(): ArrayRule
    {
        return FluentRule::array()->max(10)->each(FluentRule::string());
    }

    public function b0942(): ArrayRule
    {
        return FluentRule::array()->between(1, 5)->each(FluentRule::string());
    }

    public function b0943(): ArrayRule
    {
        return FluentRule::array()->exactly(3)->each(FluentRule::string());
    }

    public function b0944(): ArrayRule
    {
        return FluentRule::array(['a', 'b', 'c'])->each(FluentRule::string());
    }

    public function b0945(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string())->max(10);
    }

    public function b0946(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string())->between(1, 5);
    }

    public function b0947(): ArrayRule
    {
        return FluentRule::array()->rule('max:10')->each(FluentRule::string());
    }

    public function b0948(): ArrayRule
    {
        return FluentRule::list()->max(5)->each(FluentRule::string()->min(1));
    }

    public function b0949(): ArrayRule
    {
        return FluentRule::array()->max(10)->each(FluentRule::string());
    }

    public function b0950(): ArrayRule
    {
        return FluentRule::array()->between(1, 5)->each(FluentRule::string());
    }

    public function b0951(): ArrayRule
    {
        return FluentRule::array()->exactly(3)->each(FluentRule::string());
    }

    public function b0952(): ArrayRule
    {
        return FluentRule::array(['a', 'b', 'c'])->each(FluentRule::string());
    }

    public function b0953(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string())->max(10);
    }

    public function b0954(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string())->between(1, 5);
    }

    public function b0955(): ArrayRule
    {
        return FluentRule::array()->rule('max:10')->each(FluentRule::string());
    }

    public function b0956(): ArrayRule
    {
        return FluentRule::list()->max(5)->each(FluentRule::string()->min(1));
    }

    public function b0957(): ArrayRule
    {
        return FluentRule::array()->max(10)->each(FluentRule::string());
    }

    public function b0958(): ArrayRule
    {
        return FluentRule::array()->between(1, 5)->each(FluentRule::string());
    }

    public function b0959(): ArrayRule
    {
        return FluentRule::array()->exactly(3)->each(FluentRule::string());
    }

    public function b0960(): ArrayRule
    {
        return FluentRule::array(['a', 'b', 'c'])->each(FluentRule::string());
    }

    public function b0961(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string())->max(10);
    }

    public function b0962(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string())->between(1, 5);
    }

    public function b0963(): ArrayRule
    {
        return FluentRule::array()->rule('max:10')->each(FluentRule::string());
    }

    public function b0964(): ArrayRule
    {
        return FluentRule::list()->max(5)->each(FluentRule::string()->min(1));
    }

    public function b0965(): ArrayRule
    {
        return FluentRule::array()->max(10)->each(FluentRule::string());
    }

    public function b0966(): ArrayRule
    {
        return FluentRule::array()->between(1, 5)->each(FluentRule::string());
    }

    public function b0967(): ArrayRule
    {
        return FluentRule::array()->exactly(3)->each(FluentRule::string());
    }

    public function b0968(): ArrayRule
    {
        return FluentRule::array(['a', 'b', 'c'])->each(FluentRule::string());
    }

    public function b0969(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string())->max(10);
    }

    public function b0970(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string())->between(1, 5);
    }

    public function b0971(): ArrayRule
    {
        return FluentRule::array()->rule('max:10')->each(FluentRule::string());
    }

    public function b0972(): ArrayRule
    {
        return FluentRule::list()->max(5)->each(FluentRule::string()->min(1));
    }

    public function b0973(): ArrayRule
    {
        return FluentRule::array()->max(10)->each(FluentRule::string());
    }

    public function b0974(): ArrayRule
    {
        return FluentRule::array()->between(1, 5)->each(FluentRule::string());
    }

    public function b0975(): ArrayRule
    {
        return FluentRule::array()->exactly(3)->each(FluentRule::string());
    }

    public function b0976(): ArrayRule
    {
        return FluentRule::array(['a', 'b', 'c'])->each(FluentRule::string());
    }

    public function b0977(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string())->max(10);
    }

    public function b0978(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string())->between(1, 5);
    }

    public function b0979(): ArrayRule
    {
        return FluentRule::array()->rule('max:10')->each(FluentRule::string());
    }

    public function b0980(): ArrayRule
    {
        return FluentRule::list()->max(5)->each(FluentRule::string()->min(1));
    }

    public function b0981(): ArrayRule
    {
        return FluentRule::array()->max(10)->each(FluentRule::string());
    }

    public function b0982(): ArrayRule
    {
        return FluentRule::array()->between(1, 5)->each(FluentRule::string());
    }

    public function b0983(): ArrayRule
    {
        return FluentRule::array()->exactly(3)->each(FluentRule::string());
    }

    public function b0984(): ArrayRule
    {
        return FluentRule::array(['a', 'b', 'c'])->each(FluentRule::string());
    }

    public function b0985(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string())->max(10);
    }

    public function b0986(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string())->between(1, 5);
    }

    public function b0987(): ArrayRule
    {
        return FluentRule::array()->rule('max:10')->each(FluentRule::string());
    }

    public function b0988(): ArrayRule
    {
        return FluentRule::list()->max(5)->each(FluentRule::string()->min(1));
    }

    public function b0989(): ArrayRule
    {
        return FluentRule::array()->max(10)->each(FluentRule::string());
    }

    public function b0990(): ArrayRule
    {
        return FluentRule::array()->between(1, 5)->each(FluentRule::string());
    }

    public function b0991(): ArrayRule
    {
        return FluentRule::array()->exactly(3)->each(FluentRule::string());
    }

    public function b0992(): ArrayRule
    {
        return FluentRule::array(['a', 'b', 'c'])->each(FluentRule::string());
    }

    public function b0993(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string())->max(10);
    }

    public function b0994(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string())->between(1, 5);
    }

    public function b0995(): ArrayRule
    {
        return FluentRule::array()->rule('max:10')->each(FluentRule::string());
    }

    public function b0996(): ArrayRule
    {
        return FluentRule::list()->max(5)->each(FluentRule::string()->min(1));
    }

    public function b0997(): ArrayRule
    {
        return FluentRule::array()->max(10)->each(FluentRule::string());
    }

    public function b0998(): ArrayRule
    {
        return FluentRule::array()->between(1, 5)->each(FluentRule::string());
    }

    public function b0999(): ArrayRule
    {
        return FluentRule::array()->exactly(3)->each(FluentRule::string());
    }

    public function b1000(): ArrayRule
    {
        return FluentRule::array(['a', 'b', 'c'])->each(FluentRule::string());
    }
}
