import os

def test_func():
    # os.system(f"g++ {filename} -o output && ./output")
    os.system("echo hello")
    os.system("g++ --version")

if __name__ == '__main__':
    print("hi from code.py")
    test_func()
    quit()