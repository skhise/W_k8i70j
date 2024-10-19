<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Protected Page</title>
    <style>
        .number {
            width: 50%;
            padding: 10px;
            font-size: 15px;
            font-style: oblique;
            font-family: monospace;
            border: 2px solid black;
        }
    </style>
     <script>
        function resetForm() {
            document.getElementById("number").value = "";
            document.getElementById("key").value = "";
        }
    </script>
</head>
<body>
    <h1>Password Protected Content</h1>
    <form method="GET" action="{{ route('generate') }}">
            <label for="number">Enter Number:</label>
            <input  type="number" id="number" name="number" value="{{$number}}" required>
            <button type="submit">Generate Key</button>
            <button type="reset" onclick="resetForm()">Reset</button>
        </form>
        @if(isset($encrypted))
            <h2>Encrypted String:</h2>  
            <input class="number" id="key" value="{{ $encrypted }}" />
                
        @endif
   
</body>
</html>
