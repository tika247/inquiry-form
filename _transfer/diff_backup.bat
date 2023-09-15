@echo off
setlocal ENABLEDELAYEDEXPANSION

set GIT_EXE=git
set NEW_SHA=%1
set OLD_SHA=%2
set OUTPUT_DIR_ROOT=%~dp3
set /a CHECKOUT_FILE_CHAR_MAX=1000
set /a CMD_LEN=0
set DIFF_LIST=""
set hyphen=-
set time2=%time: =0%
set OUTPUT_DIR_NAME=_diff_%date:~-10,4%%hyphen%%date:~-5,2%%hyphen%%date:~-2,2%_%time2:~0,2%%hyphen%%time2:~3,2%%hyphen%%time2:~6,2%
mkdir %OUTPUT_DIR_ROOT%%OUTPUT_DIR_NAME%

for /f "usebackq" %%A in (`%GIT_EXE% diff --name-only --diff-filter=ACMR %OLD_SHA%..%NEW_SHA%`) do (
    call :FOR_PROC %%A "!DIFF_LIST!"
)
call :GIT_CHECKOUT_INDEX "!DIFF_LIST!"

echo ^^(*^^^^ _^ ^^^^*)^ sabun^^! to %OUTPUT_DIR_ROOT%%OUTPUT_DIR_NAME%
exit /b

:FOR_PROC
    set TMP_FILE_NAME=%1
    :LEN_LOOP
    if not "%TMP_FILE_NAME%"=="" (
        set TMP_FILE_NAME=%TMP_FILE_NAME:~1%
        set /a CMD_LEN=%CMD_LEN%+1
        goto LEN_LOOP
    )

    set /a CMD_LEN=%CMD_LEN%+1

    if %CMD_LEN% LEQ %CHECKOUT_FILE_CHAR_MAX% (
        if !DIFF_LIST!=="" (
            set DIFF_LIST=%1
        ) else (
            set DIFF_LIST=!DIFF_LIST! %1
        )

    ) else (
        set /a CMD_LEN=0
        call :GIT_CHECKOUT_INDEX "!DIFF_LIST!"
        set DIFF_LIST=%1
    )
exit /b

:GIT_CHECKOUT_INDEX
    set TMP_CHECKOUT_LIST=%1
    set TMP_CHECKOUT_LIST=%TMP_CHECKOUT_LIST:~1%
    set TMP_CHECKOUT_LIST=%TMP_CHECKOUT_LIST:~-0,-1%

    %GIT_EXE% checkout-index --prefix=%OUTPUT_DIR_ROOT%%OUTPUT_DIR_NAME%\ -f %TMP_CHECKOUT_LIST%
exit /b

endlocal