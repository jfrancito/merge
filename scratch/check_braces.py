
import sys

def count_braces(filepath):
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()
    
    open_braces = content.count('{')
    close_braces = content.count('}')
    open_parens = content.count('(')
    close_parens = content.count(')')
    
    print(f"Braces: {{: {open_braces}, }}: {close_braces}")
    print(f"Parens: (: {open_parens}, ): {close_parens}")

if __name__ == "__main__":
    count_braces(sys.argv[1])
