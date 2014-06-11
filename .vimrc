" autoload the local .vimrc file you need to have
" https://github.com/MarcWeber/vim-addon-local-vimrc
" plugin installed

let g:syntastic_php_checkers = ['php']
let g:syntastic_mode_map = {'mode': 'active'}


let g:ctrlp_custom_ignore = '\.git$\|\.tmp$\|\.work$\|vendor$'

autocmd Filetype php nnoremap <silent> <buffer> <Leader>a :!vendor/bin/phpunit<CR>
autocmd Filetype php nnoremap <silent> <buffer> <Leader>o :call OpenCurrentTest()<CR>
autocmd Filetype php nnoremap <silent> <buffer> <Leader>t
  \ :setlocal nocursorline <BAR> call RunCurrentTest() <BAR> setlocal cursorline<CR>
autocmd Filetype php nnoremap <silent> <buffer> <Leader>f
  \ :setlocal nocursorline <BAR> call RunCurrentFunction() <BAR> setlocal cursorline<CR>
autocmd Filetype php nnoremap <silent> <buffer> <Leader>e
  \ :setlocal nocursorline <BAR> call RunCurrentLine() <BAR> setlocal cursorline<CR>

" note that the following only works with tpope/vim-commentary plugin
" cannot say something like if exists("g:loaded_commentary") because
" this file is sourced before commentary plugin, need to find a solution
" for this...
autocmd Filetype php nnoremap <silent> <buffer> <Leader>c :g/\<var_dump\>/ :normal gcc<CR>


function! RunCurrentLine()
  exec '!php -r "var_dump(' . substitute(getline('.'), '^\s\+\|;$', '', 'g') . ');"'
endfunction

function! RunCurrentFunction()
  let l:current_file=expand('%:p')
  if match(l:current_file, 'Test\.php$') != -1
    let l:function_pattern='\C^\s*\%(public\s\+\|static\s\+\|abstract\s\+\|protected\s\+\|private\s\+\)*function\s\+\([^(]\+\)\s*(.*$'
    let l:function_line=search(l:function_pattern, 'bcnW')
    if l:function_line > 0
      let l:matches=matchlist(getline(l:function_line), l:function_pattern)
      exec '!vendor/bin/phpunit --filter="' . l:matches[1] . '$"' l:current_file
    endif
  endif
endfunction


function! RunCurrentTest()
  let l:current_file=expand('%:p')
  let l:test_file='nothing'
  if match(l:current_file, 'Test\.php$') != -1
    let l:test_file=l:current_file
  else
    let l:test_file=SearchForRelatedTestFile(l:current_file)
  endif
  if l:test_file != 'nothing'
    exec '!vendor/bin/phpunit' l:test_file
  else
    echo 'sorry, nothing to run :-('
  endif
endfunction

function! OpenCurrentTest()
  let l:current_file=expand("%:p")
  let l:test_file="nothing"
  let l:test_file=SearchForRelatedTestFile(l:current_file)
  if l:test_file != "nothing"
    exec ":belowright :split " l:test_file
  else
    echo "sorry, nothing to open :-("
  endif
endfunction


function! SearchForRelatedTestFile(file_path)
  let l:file_name=fnamemodify(a:file_path, ":t")
  let l:test_file_name=fnamemodify(l:file_name, ":r") . "Test.php"
  let l:project_root_path=ProjectRootGuess(a:file_path)
  let l:found=system("find '".l:project_root_path."/tests' -name '".l:test_file_name."'")
  let l:number_of_file_founds=strlen(substitute(l:found, "[^\n]", "", "g"))
  if l:number_of_file_founds == 1
    return l:found
  endif
endfunction


function! ProjectRootGuess(file_path)
  for l:marker in [".git", ".vimrc"]
    let l:result=""
    let l:pivot=a:file_path
    while l:pivot!=fnamemodify(l:pivot, ":h")
      let l:pivot=fnamemodify(l:pivot, ":h")
      if len(glob(l:pivot."/".l:marker))
        let l:result=l:pivot
      endif
    endwhile
    if len(l:result)
      return l:result
    endif
  endfor
  return filereadable(a:file_path) ? fnamemodify(a:file_path, ":h") : a:file_path
endfunction
