# Audio subtitle generator
Subtitle generator using Whisper.PHP from an audio input.

## Prerequisites

- PHP >=8.3
- Composer
- FFI
- JIT (optional, for performance)

## Usage

After cloning the repository and running `composer install`, to display the command's usage:

```shell
php generate-subtitle.php -h
```

### Options

```
-f, --filepath=<file_path>         File path of the audio to be transcribed
-p, --prompt=<initial_prompt>      Text (or file path) of the initial prompt for context about the audio
-m, --model=<model>                Model to be used (tiny.en, tiny, base.en, base, small.en, small, medium.en, medium, large-v1, large-v2, large-v3, large) (default: tiny.en)
-t, --threads=<number_of_threads>  Number of threads to use (default: 16)
-l, --language=<language>          Two letter code of the audio's language. (default: autodetect)
-o, --output=<output_path>         Output path of the subtitle file (.srt extension)
```

### Example:

The following example will generate the subtitle subtitle.srt inside /path based on the audio.mp3 file in the same path:

```shell
php generate-subtitle.php \
    -f=audio.mp3 \
    --prompt="Initial prompt for context about the audio" \
    --model=small \
    -t8 \
    -l=pt \
    --output=/app/subtitle.srt
```

## Docker

If you prefer, you can use Docker to run this tool:

https://hub.docker.com/r/cviniciussdias/audio-subtitle-generator
