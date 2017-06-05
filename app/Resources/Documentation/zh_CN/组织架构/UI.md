用户界面
========

### 模板模型化

这是一次大胆的尝试，我没有相关的经验，只是凭感觉这么做的。

模型：

1. Bundle, 此 Entity (目前)是用户自定义 Bundle 。
2. Twig，上边 Bundle 包含的 Twig 文件。
3. Block，上边 Twig 文件包含的 Block，里边有一个 spfState 属性，用来判断是否需要采用 Spfjs 的加载方式。

命令工具：

在 AdminBundle 目前有两个 Command，一个是 ListBundlesCommand, 一个是 SunshineImportTemplatesCommand
1. ListBundlesCommand
    * 命令：bin/console list:bundles mine --with-twig
    * 将
2. SunshineImportTemplatesCommand
    * 命令：bin/console sunshine:import-templates --bundle-name-contains=Sunshine
    * 将引入以 'Sunshine' 开头的Bundle的所有 Twig 和 Block 信息。