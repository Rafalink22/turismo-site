import os

# CONFIGURAÇÕES DE FILTRO
# Pastas que serão completamente ignoradas
IGNORAR_PASTAS = {
    '.git', '.vscode', '.idea', '__pycache__', 
    'node_modules', 'vendor', 
    'uploads', 'img', 'images' # Ignora pastas de mídia para não poluir
}

# Extensões de arquivos que não vamos ler o conteúdo (apenas listar)
IGNORAR_EXTENSOES = {
    '.png', '.jpg', '.jpeg', '.gif', '.ico', '.webp', '.svg', 
    '.pdf', '.zip', '.rar', '.exe', '.dll', 
    '.pyc', '.git', '.lock'
}

# O nome do arquivo que será gerado
ARQUIVO_SAIDA = 'PROJETO_COMPLETO.txt'

def gerar_arvore(raiz, padding=''):
    """Gera uma representação visual da estrutura de pastas"""
    resultado = ''
    files = []
    dirs = []

    try:
        conteudo = os.listdir(raiz)
    except PermissionError:
        return ''

    for nome in sorted(conteudo):
        caminho_completo = os.path.join(raiz, nome)
        if os.path.isdir(caminho_completo):
            if nome not in IGNORAR_PASTAS:
                dirs.append(nome)
        else:
            files.append(nome)

    # Processa pastas
    for i, pasta in enumerate(dirs):
        eh_ultimo = (i == len(dirs) - 1) and (len(files) == 0)
        prefixo = '└── ' if eh_ultimo else '├── '
        resultado += f"{padding}{prefixo}{pasta}/\n"
        # Recursão
        novo_padding = padding + ('    ' if eh_ultimo else '│   ')
        resultado += gerar_arvore(os.path.join(raiz, pasta), novo_padding)

    # Processa arquivos
    for i, arquivo in enumerate(files):
        if arquivo == ARQUIVO_SAIDA or arquivo == os.path.basename(__file__):
            continue
        eh_ultimo = (i == len(files) - 1)
        prefixo = '└── ' if eh_ultimo else '├── '
        resultado += f"{padding}{prefixo}{arquivo}\n"
    
    return resultado

def escrever_conteudos(raiz, arquivo_saida):
    """Lê e escreve o conteúdo de cada arquivo válido"""
    
    separador = "=" * 80
    
    with open(arquivo_saida, 'w', encoding='utf-8') as f_out:
        # 1. Escreve a Árvore de Diretórios
        f_out.write(f"{separador}\nESTRUTURA DE DIRETÓRIOS\n{separador}\n")
        f_out.write(f"Raiz: {raiz}\n\n")
        f_out.write(gerar_arvore(raiz))
        f_out.write("\n\n")

        # 2. Escreve o Conteúdo dos Arquivos
        f_out.write(f"{separador}\nCONTEÚDO DOS ARQUIVOS\n{separador}\n\n")

        for root, dirs, files in os.walk(raiz):
            # Remove pastas ignoradas para não entrar nelas
            dirs[:] = [d for d in dirs if d not in IGNORAR_PASTAS]

            for file in files:
                # Pula o próprio script e o arquivo de saída
                if file == ARQUIVO_SAIDA or file == os.path.basename(__file__):
                    continue

                ext = os.path.splitext(file)[1].lower()
                caminho_completo = os.path.join(root, file)
                caminho_relativo = os.path.relpath(caminho_completo, raiz)

                if ext in IGNORAR_EXTENSOES:
                    f_out.write(f"--- ARQUIVO: {caminho_relativo} (Conteúdo binário/mídia ignorado) ---\n\n")
                    continue

                try:
                    with open(caminho_completo, 'r', encoding='utf-8', errors='ignore') as f_in:
                        conteudo = f_in.read()
                        f_out.write(f"--- INICIO ARQUIVO: {caminho_relativo} ---\n")
                        f_out.write(conteudo)
                        f_out.write(f"\n--- FIM ARQUIVO: {caminho_relativo} ---\n")
                        f_out.write(f"\n{'-'*40}\n\n")
                except Exception as e:
                    f_out.write(f"--- ERRO AO LER: {caminho_relativo} ({str(e)}) ---\n\n")

if __name__ == "__main__":
    diretorio_atual = os.getcwd()
    print(f"Gerando relatório de: {diretorio_atual}...")
    escrever_conteudos(diretorio_atual, ARQUIVO_SAIDA)
    print(f"Sucesso! Arquivo '{ARQUIVO_SAIDA}' criado.")