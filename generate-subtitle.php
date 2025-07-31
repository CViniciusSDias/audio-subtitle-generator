<?php

use Codewithkyrian\Whisper\{Whisper, WhisperFullParams};
use function Codewithkyrian\Whisper\{outputSrt, readAudio};

require_once __DIR__ . '/vendor/autoload.php';

$options = getopt(
	'f::p::m::t::l::o::h',
	['filepath::', 'prompt::', 'model::', 'threads::', 'language::', 'output', 'help']
);

if (array_key_exists('h', $options) || array_key_exists('help', $options)) {
	displayHelp($argv[0]);
}

$nThreads = $options['t'] ?? $options['threads'] ?? 16;
$params = WhisperFullParams::default()
	->withNThreads($nThreads);

$language = $options['l'] ?? $options['language'] ?? null;
if ($language) {
	$params = $params->withLanguage($language);
}

$initialPrompt = $options['p'] ?? $options['prompt'] ?? '';
if (file_exists($initialPrompt)) {
	$params = $params->withInitialPrompt(file_get_contents($initialPrompt));
} else if (!empty($initialPrompt)) {
	$params = $params->withInitialPrompt($initialPrompt);
}

$model = $options['m'] ?? $options['model'] ?? 'tiny.en';
$whisper = Whisper::fromPretrained($model, __DIR__ . '/models', $params);

$audio = readAudio($options['f'] ?? $options['filepath'] ?? 'audio.mp3');
$segments = $whisper->transcribe($audio, $nThreads);

outputSrt($segments, $options['o'] ?? $options['output'] ?? 'subtitle.srt');

function displayHelp(string $script): never
{
	$models = implode(', ', Whisper::MODELS);

	echo <<<HELP
	Usage: php $script [options]
	
	Options:
	 -f, --filepath=<file_path>       \t File path of the audio to be transcribed
	 -p, --prompt=<initial_prompt>    \t Text (or file path) of the initial prompt for context about the audio
	 -m, --model=<model>              \t Model to be used ($models) (default: tiny.en)
	 -t, --threads=<number_of_threads>\t Number of threads to use (default: 16)
	 -l, --language=<language>        \t Two letter code of the audio's language. (default: autodetect)
	 -o, --output=<output_path>       \t Output path of the subtitle file (.srt extension)
	
	Example:
	php $script -f=audio.mp3 --prompt="Initial prompt for context about the audio" --model=small -t16 -l=pt --output=/full/path/subtitle.srt

	HELP;

	exit(0);
}
